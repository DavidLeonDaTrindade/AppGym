<?php

namespace App\Http\Controllers;

use App\Models\ClientDiet;
use App\Models\ClientRoutine;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ClientDashboardController extends Controller
{
    public function dashboard(Request $request): View
    {
        return view('client.dashboard', [
            'user' => $request->user(),
            'currentRoutine' => $this->currentRoutine($request),
            'currentDiet' => $this->currentDiet($request),
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
}
