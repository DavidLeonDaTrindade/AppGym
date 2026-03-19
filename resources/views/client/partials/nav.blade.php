<nav class="nav">
    <div>
        <strong>AppGym</strong>
        <div class="muted">Área cliente</div>
    </div>
    <div class="nav-links">
        <a href="{{ route('dashboard') }}" class="{{ $active === 'dashboard' ? 'active' : '' }}">Resumen</a>
        <a href="{{ route('client.routine') }}" class="{{ $active === 'routine' ? 'active' : '' }}">Rutina</a>
        <a href="{{ route('client.diet') }}" class="{{ $active === 'diet' ? 'active' : '' }}">Dieta</a>
        <a href="{{ route('client.progress') }}" class="{{ $active === 'progress' ? 'active' : '' }}">Progreso</a>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Salir</button>
    </form>
</nav>
