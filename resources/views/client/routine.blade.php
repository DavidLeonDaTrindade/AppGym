<x-layouts.app :title="'Mi rutina'">
    <main class="shell">
        @include('client.partials.nav', ['active' => 'routine'])
        <section class="card">
            <p class="eyebrow">Rutina de entrenamiento</p>
            @if (! $currentRoutine)
                <div class="card empty">
                    <h2>Sin rutina activa</h2>
                    <p class="muted">Cuando tu entrenador te asigne una rutina aparecerá aquí.</p>
                </div>
            @else
                <h1>{{ $currentRoutine->routine->title }}</h1>
                <p class="muted">{{ $currentRoutine->routine->description }}</p>
                <ul class="clean" style="margin-top:1.5rem">
                    @foreach ($currentRoutine->routine->exercises as $exercise)
                        <li>
                            <h3>{{ $exercise->sort_order ?: $loop->iteration }}. {{ $exercise->name }}</h3>
                            <p class="muted">Series: {{ $exercise->sets ?: '-' }} | Repeticiones: {{ $exercise->reps ?: '-' }} | Descanso: {{ $exercise->rest_seconds ? $exercise->rest_seconds . 's' : '-' }}</p>
                            @if ($exercise->instructions)
                                <p>{{ $exercise->instructions }}</p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </main>
</x-layouts.app>
