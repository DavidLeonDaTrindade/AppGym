<?php

namespace App\Http\Controllers;

use App\Models\BodyMeasurement;
use App\Models\ClientDiet;
use App\Models\ClientRoutine;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ClientDashboardController extends Controller
{
    public function dashboard(Request $request): View
    {
        $measurementHistory = $this->measurementHistory($request);

        return view('client.dashboard', [
            'user' => $request->user(),
            'currentRoutine' => $this->currentRoutine($request),
            'currentDiet' => $this->currentDiet($request),
            'latestMeasurement' => $measurementHistory->last(),
            'chartSeries' => $this->chartSeries($measurementHistory),
        ]);
    }

    public function routine(Request $request): View
    {
        return view('client.routine', [
            'user' => $request->user(),
            'currentRoutine' => $this->currentRoutine($request),
        ]);
    }

    public function diet(Request $request): View
    {
        return view('client.diet', [
            'user' => $request->user(),
            'currentDiet' => $this->currentDiet($request),
        ]);
    }

    public function progress(Request $request): View
    {
        $measurementHistory = $this->measurementHistory($request);
        $editMeasurement = null;

        if ($request->filled('edit')) {
            $editMeasurement = $request->user()
                ->measurements()
                ->whereKey($request->integer('edit'))
                ->first();
        }

        return view('client.progress', [
            'user' => $request->user(),
            'latestMeasurement' => $measurementHistory->last(),
            'measurementHistory' => $measurementHistory->reverse()->values(),
            'chartSeries' => $this->chartSeries($measurementHistory),
            'editMeasurement' => $editMeasurement,
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $data = $request->validate($this->profileRules());

        $request->user()->update($data);

        return back()->with('status', 'Tu perfil corporal se ha actualizado.');
    }

    public function storeMeasurement(Request $request): RedirectResponse
    {
        $data = $this->validatedMeasurementData($request);

        /** @var \App\Models\User $user */
        $user = $request->user();

        $measurement = $user->measurements()->create($data);
        $user->syncPhysicalMetricsFromMeasurement($measurement);

        return back()->with('status', 'La nueva medición se ha guardado y ya se refleja en tu progreso.');
    }

    public function updateMeasurement(Request $request, BodyMeasurement $measurement): RedirectResponse
    {
        abort_unless($measurement->client_id === $request->user()->id, 403);

        $measurement->update($this->validatedMeasurementData($request));
        $this->syncLatestMeasurement($request);

        return redirect()
            ->route('client.progress')
            ->with('status', 'La medición se ha actualizado correctamente.');
    }

    public function destroyMeasurement(Request $request, BodyMeasurement $measurement): RedirectResponse
    {
        abort_unless($measurement->client_id === $request->user()->id, 403);

        $measurement->delete();
        $this->syncLatestMeasurement($request);

        return back()->with('status', 'La medición se ha eliminado del histórico.');
    }

    private function currentRoutine(Request $request): ?ClientRoutine
    {
        return $request->user()
            ->clientRoutineAssignments()
            ->with(['routine.exercises', 'trainer'])
            ->current()
            ->orderByDesc('starts_at')
            ->orderByDesc('id')
            ->first();
    }

    private function currentDiet(Request $request): ?ClientDiet
    {
        return $request->user()
            ->clientDietAssignments()
            ->with(['diet', 'trainer'])
            ->current()
            ->orderByDesc('starts_at')
            ->orderByDesc('id')
            ->first();
    }

    private function measurementHistory(Request $request): Collection
    {
        return $request->user()
            ->measurements()
            ->orderBy('measured_at')
            ->orderBy('id')
            ->get();
    }

    private function profileRules(): array
    {
        return [
            'age' => ['required', 'integer', 'min:0'],
            'training_years' => ['required', 'integer', 'min:0'],
            'height_cm' => ['required', 'numeric', 'min:0'],
            'weight_kg' => ['required', 'numeric', 'min:0'],
            'body_mass_index' => ['required', 'numeric', 'min:0'],
            'muscle_mass_index' => ['required', 'numeric', 'min:0'],
            'body_fat_percentage' => ['required', 'numeric', 'min:0'],
            'muscle_mass_kg' => ['required', 'numeric', 'min:0'],
            'goal_weight_kg' => ['required', 'numeric', 'min:0'],
            'waist_cm' => ['required', 'numeric', 'min:0'],
        ];
    }

    private function validatedMeasurementData(Request $request): array
    {
        $data = $request->validate(array_merge(
            ['measured_at' => ['required', 'date']],
            $this->profileRules(),
            ['notes' => ['nullable', 'string']]
        ));

        if ((float) $data['body_mass_index'] === 0.0 && (float) $data['height_cm'] > 0 && (float) $data['weight_kg'] > 0) {
            $heightInMeters = ((float) $data['height_cm']) / 100;
            $data['body_mass_index'] = round(((float) $data['weight_kg']) / ($heightInMeters ** 2), 2);
        }

        return $data;
    }

    private function syncLatestMeasurement(Request $request): void
    {
        $latestMeasurement = $request->user()
            ->measurements()
            ->orderByDesc('measured_at')
            ->orderByDesc('id')
            ->first();

        if ($latestMeasurement) {
            $request->user()->syncPhysicalMetricsFromMeasurement($latestMeasurement);

            return;
        }

        $request->user()->update([
            'age' => 0,
            'training_years' => 0,
            'height_cm' => 0,
            'weight_kg' => 0,
            'body_mass_index' => 0,
            'muscle_mass_index' => 0,
            'body_fat_percentage' => 0,
            'muscle_mass_kg' => 0,
            'goal_weight_kg' => 0,
            'waist_cm' => 0,
        ]);
    }

    private function chartSeries(Collection $measurements): array
    {
        return [
            $this->makeSeries($measurements, 'weight_kg', 'Peso', '#c26d3d', 'kg'),
            $this->makeSeries($measurements, 'body_fat_percentage', 'Grasa corporal', '#9f1239', '%'),
            $this->makeSeries($measurements, 'muscle_mass_kg', 'Masa muscular', '#1f7a52', 'kg'),
        ];
    }

    private function makeSeries(Collection $measurements, string $field, string $label, string $color, string $unit): array
    {
        $values = $measurements->map(fn (BodyMeasurement $measurement): array => [
            'label' => $measurement->measured_at->format('d/m'),
            'value' => (float) $measurement->{$field},
        ])->values();

        return [
            'label' => $label,
            'color' => $color,
            'unit' => $unit,
            'latest' => $values->last()['value'] ?? 0,
            'change' => count($values) > 1 ? round(($values->last()['value'] ?? 0) - ($values->first()['value'] ?? 0), 2) : 0,
            'points' => $this->svgPoints($values),
            'values' => $values,
        ];
    }

    private function svgPoints(Collection $values): string
    {
        if ($values->isEmpty()) {
            return '';
        }

        if ($values->count() === 1) {
            return '12,88 156,44 300,88';
        }

        $max = max((float) $values->max('value'), 1);
        $min = (float) $values->min('value');
        $spread = max($max - $min, 1);
        $width = 300;
        $height = 96;

        return $values->values()->map(function (array $point, int $index) use ($values, $min, $spread, $width, $height): string {
            $x = (int) round(($index / max($values->count() - 1, 1)) * $width);
            $y = (int) round($height - (((float) $point['value'] - $min) / $spread) * $height);

            return $x . ',' . $y;
        })->implode(' ');
    }
}
