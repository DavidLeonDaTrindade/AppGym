<article class="chart">
    <div class="chart-meta">
        <div>
            <p class="eyebrow" style="margin-bottom:.3rem">{{ $series['label'] }}</p>
            <strong style="font-size:1.65rem">{{ number_format((float) $series['latest'], 1) }} {{ $series['unit'] }}</strong>
        </div>
        <div class="{{ $series['change'] < 0 ? 'delta-down' : 'delta-up' }}" style="font-weight:700">
            {{ $series['change'] > 0 ? '+' : '' }}{{ number_format((float) $series['change'], 1) }} {{ $series['unit'] }}
        </div>
    </div>
    @if (count($series['values']) > 0)
        <svg viewBox="0 0 300 120" aria-label="Gráfica de {{ strtolower($series['label']) }}">
            <line x1="0" y1="96" x2="300" y2="96" stroke="#e5d7bf" stroke-width="1" />
            <polyline
                fill="none"
                stroke="{{ $series['color'] }}"
                stroke-width="4"
                stroke-linecap="round"
                stroke-linejoin="round"
                points="{{ $series['points'] }}"
            />
        </svg>
        <div style="display:flex;justify-content:space-between;gap:.5rem;font-size:.88rem;color:#6b7280">
            <span>{{ $series['values']->first()['label'] }}</span>
            <span>{{ $series['values']->last()['label'] }}</span>
        </div>
    @else
        <p class="muted" style="margin:0">Aún no hay mediciones guardadas para generar esta gráfica.</p>
    @endif
</article>
