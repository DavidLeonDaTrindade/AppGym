<x-layouts.app :title="'Acceso AppGym'">
    <main class="shell">
        <section class="card auth-card">
            <p class="eyebrow">Acceso de clientes y entrenadores</p>
            <h1>Entra en tu cuenta</h1>
            <p class="muted">Solo pueden acceder los usuarios dados de alta por su entrenador.</p>
            <form method="POST" action="{{ route('login.store') }}">
                @csrf
                <div style="margin-top:1rem">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div style="margin-top:1rem">
                    <label for="password">Contraseña</label>
                    <input id="password" type="password" name="password" required>
                    @error('password')<div class="error">{{ $message }}</div>@enderror
                </div>
                <label style="display:flex;align-items:center;gap:.6rem;margin:1rem 0 1.5rem;font-weight:400">
                    <input type="checkbox" name="remember" value="1" style="width:auto">
                    Recordarme
                </label>
                <button class="btn-primary" type="submit">Acceder</button>
            </form>
        </section>
    </main>
</x-layouts.app>
