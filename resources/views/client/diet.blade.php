<x-layouts.app :title="'Mi dieta'">
    <main class="shell">
        @include('client.partials.nav', ['active' => 'diet'])
        <section class="card">
            <p class="eyebrow">Plan nutricional</p>
            @if (! $currentDiet)
                <div class="card empty">
                    <h2>Sin dieta activa</h2>
                    <p class="muted">Cuando tu entrenador publique una recomendación nutricional la verás en esta sección.</p>
                </div>
            @else
                <h1>{{ $currentDiet->diet->title }}</h1>
                <p class="muted">{{ $currentDiet->diet->summary }}</p>
                @if ($currentDiet->notes)
                    <p><strong>Notas del entrenador:</strong> {{ $currentDiet->notes }}</p>
                @endif
                <div class="card" style="margin-top:1.25rem;white-space:pre-wrap">{{ $currentDiet->diet->content }}</div>
            @endif
        </section>
    </main>
</x-layouts.app>
