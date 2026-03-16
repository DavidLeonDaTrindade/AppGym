<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AppGym</title>
    <style>
        body{margin:0;font-family:Georgia,"Times New Roman",serif;background:linear-gradient(135deg,#f8f3ea 0%,#d8e2dc 100%);color:#1f2937}
        .hero{min-height:100vh;display:grid;place-items:center;padding:2rem}
        .card{max-width:760px;background:rgba(255,255,255,.88);border:1px solid rgba(31,41,55,.08);border-radius:28px;padding:3rem;box-shadow:0 25px 60px rgba(15,23,42,.12)}
        h1{font-size:clamp(2.4rem,6vw,4.8rem);margin:0 0 1rem;line-height:.95}
        p{font-size:1.05rem;line-height:1.7;margin:0 0 1.2rem}
        .actions{display:flex;flex-wrap:wrap;gap:1rem;margin-top:2rem}
        .btn{text-decoration:none;padding:.95rem 1.3rem;border-radius:999px;font-weight:700}
        .btn-primary{background:#111827;color:#fff}
        .btn-secondary{border:1px solid #111827;color:#111827}
    </style>
</head>
<body>
    <main class="hero">
        <section class="card">
            <p>Entrenamiento personal</p>
            <h1>Rutinas y dietas en un solo lugar.</h1>
            <p>Los entrenadores gestionan clientes, crean planes y asignan seguimiento desde el panel de administración. Los clientes acceden con su usuario para consultar su plan actual.</p>
            <div class="actions">
                <a class="btn btn-primary" href="{{ route('login') }}">Entrar a la app</a>
                <a class="btn btn-secondary" href="/admin/login">Panel entrenador</a>
            </div>
        </section>
    </main>
</body>
</html>
