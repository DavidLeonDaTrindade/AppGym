<x-layouts.app :title="'Panel cliente'">
    <main class="shell">
        @include('client.partials.nav', ['active' => 'dashboard'])
        @if (session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif
        <section class="card" style="margin-bottom:1.25rem">
            <p class="eyebrow">Tu espacio personal</p>
            <h1>{{ $user->name }}</h1>
            <p class="muted">Consulta tu planificación actual, revisa tu rutina y sigue la dieta marcada por tu entrenador.</p>
        </section>
        <section class="grid">
            <article class="card {{ $currentRoutine ? '' : 'empty' }}">
                <p class="eyebrow">Rutina actual</p>
                @if ($currentRoutine)
                    <h2>{{ $currentRoutine->routine->title }}</h2>
                    <p class="muted">{{ $currentRoutine->routine->description }}</p>
                    <span class="pill">{{ $currentRoutine->routine->exercises->count() }} ejercicios</span>
                @else
                    <h2>Sin rutina asignada</h2>
                    <p class="muted">Tu entrenador todavía no ha publicado una rutina activa para ti.</p>
                @endif
            </article>
            <article class="card {{ $currentDiet ? '' : 'empty' }}">
                <p class="eyebrow">Dieta actual</p>
                @if ($currentDiet)
                    <h2>{{ $currentDiet->diet->title }}</h2>
                    <p class="muted">{{ $currentDiet->diet->summary }}</p>
                    <span class="pill">Plan activo</span>
                @else
                    <h2>Sin dieta asignada</h2>
                    <p class="muted">Tu entrenador todavía no ha cargado una recomendación nutricional activa.</p>
                @endif
            </article>
        </section>
        <section class="card" style="margin-top:1.25rem">
            <div style="display:flex;justify-content:space-between;gap:1rem;align-items:center;flex-wrap:wrap;margin-bottom:1rem">
                <div>
                    <p class="eyebrow">Progreso corporal</p>
                    <h2 style="margin-bottom:.4rem">Tu evolución</h2>
                    <p class="muted" style="margin:0">Registra tus mediciones y revisa si bajas grasa mientras ganas músculo.</p>
                </div>
                <a href="{{ route('client.progress') }}" class="btn-secondary">Actualizar datos</a>
            </div>
            <div class="stats-grid" style="margin-bottom:1rem">
                <div class="stat">
                    <span class="muted">Peso actual</span>
                    <strong>{{ number_format((float) $user->weight_kg, 1) }} kg</strong>
                </div>
                <div class="stat">
                    <span class="muted">% grasa</span>
                    <strong>{{ number_format((float) $user->body_fat_percentage, 1) }}%</strong>
                </div>
                <div class="stat">
                    <span class="muted">Masa muscular</span>
                    <strong>{{ number_format((float) $user->muscle_mass_kg, 1) }} kg</strong>
                </div>
                <div class="stat">
                    <span class="muted">Última medición</span>
                    <strong>{{ $latestMeasurement ? $latestMeasurement->measured_at->format('d/m/Y') : 'Sin datos' }}</strong>
                </div>
            </div>
            <div class="grid two">
                @foreach ($chartSeries as $series)
                    @include('client.partials.progress-chart', ['series' => $series])
                @endforeach
            </div>
        </section>
    </main>
</x-layouts.app>
