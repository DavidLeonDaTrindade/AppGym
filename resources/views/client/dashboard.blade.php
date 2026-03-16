<x-layouts.app :title="'Panel cliente'">
    <main class="shell">
        @include('client.partials.nav', ['active' => 'dashboard'])
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
    </main>
</x-layouts.app>
