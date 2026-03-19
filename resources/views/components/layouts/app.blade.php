<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'AppGym' }}</title>
    <style>
        :root{--bg:#f5efe4;--panel:#fff;--ink:#1f2937;--muted:#6b7280;--line:#e5d7bf;--accent:#c26d3d;--accent-dark:#7c3f1d;--success:#1f7a52}
        *{box-sizing:border-box}
        body{margin:0;font-family:Georgia,"Times New Roman",serif;background:radial-gradient(circle at top left,rgba(194,109,61,.15),transparent 22%),linear-gradient(180deg,#fbf7f1 0%,var(--bg) 100%);color:var(--ink)}
        a{color:inherit}
        .shell{max-width:1100px;margin:0 auto;padding:1.5rem}
        .nav{display:flex;justify-content:space-between;align-items:center;gap:1rem;margin-bottom:2rem;padding:1rem 1.25rem;background:rgba(255,255,255,.75);border:1px solid rgba(124,63,29,.12);border-radius:22px;backdrop-filter:blur(12px)}
        .brand-lockup{display:flex;align-items:center;gap:.9rem;min-width:0}
        .brand-logo{width:78px;height:78px;object-fit:contain;filter:drop-shadow(0 10px 18px rgba(124,63,29,.16))}
        .nav-links{display:flex;gap:.75rem;flex-wrap:wrap}
        .nav-links a,.nav button{text-decoration:none;border:0;background:transparent;font:inherit;cursor:pointer;padding:.75rem 1rem;border-radius:999px}
        .nav-links a.active{background:var(--ink);color:#fff}
        .nav button{color:var(--accent-dark);border:1px solid rgba(124,63,29,.25)}
        .grid{display:grid;gap:1.25rem;grid-template-columns:repeat(auto-fit,minmax(260px,1fr))}
        .grid.two{grid-template-columns:repeat(auto-fit,minmax(320px,1fr))}
        .card{background:var(--panel);border:1px solid var(--line);border-radius:24px;padding:1.4rem;box-shadow:0 20px 40px rgba(31,41,55,.08)}
        .eyebrow{margin:0 0 .45rem;color:var(--accent-dark);font-size:.85rem;text-transform:uppercase;letter-spacing:.08em}
        h1,h2,h3{margin-top:0}
        .muted{color:var(--muted)}
        .empty{border:1px dashed var(--line);background:rgba(255,255,255,.55)}
        .pill{display:inline-flex;align-items:center;padding:.3rem .65rem;border-radius:999px;background:rgba(31,122,82,.1);color:var(--success);font-size:.9rem}
        ul.clean{list-style:none;padding:0;margin:0}
        ul.clean li+li{margin-top:1rem;padding-top:1rem;border-top:1px solid var(--line)}
        .auth-card{max-width:460px;margin:8vh auto}
        label{display:block;font-weight:700;margin-bottom:.45rem}
        input,textarea{width:100%;border:1px solid #d4c2ab;border-radius:16px;padding:.9rem 1rem;font:inherit;background:rgba(255,255,255,.95)}
        textarea{min-height:160px}
        input[type="date"]{appearance:none}
        .btn-primary{width:100%;border:0;border-radius:999px;padding:.95rem 1.2rem;background:linear-gradient(90deg,var(--accent-dark),var(--accent));color:#fff;font:inherit;font-weight:700;cursor:pointer}
        .btn-secondary{display:inline-flex;align-items:center;justify-content:center;border:1px solid rgba(124,63,29,.25);border-radius:999px;padding:.8rem 1.1rem;background:#fff;color:var(--accent-dark);font:inherit;font-weight:700;cursor:pointer;text-decoration:none}
        .btn-danger{display:inline-flex;align-items:center;justify-content:center;border:1px solid rgba(159,18,57,.25);border-radius:999px;padding:.7rem 1rem;background:#fff5f7;color:#9f1239;font:inherit;font-weight:700;cursor:pointer;text-decoration:none}
        .actions-inline{display:flex;gap:.6rem;flex-wrap:wrap}
        .stack{display:grid;gap:1rem}
        .form-grid{display:grid;gap:1rem;grid-template-columns:repeat(auto-fit,minmax(180px,1fr))}
        .stats-grid{display:grid;gap:1rem;grid-template-columns:repeat(auto-fit,minmax(150px,1fr))}
        .stat{padding:1rem;border:1px solid rgba(124,63,29,.12);border-radius:18px;background:linear-gradient(180deg,#fff,#fbf6ee)}
        .stat strong{display:block;font-size:1.55rem;margin-top:.35rem}
        .chart{padding:1rem;border:1px solid rgba(124,63,29,.12);border-radius:20px;background:linear-gradient(180deg,#fff,#fcfaf6)}
        .chart svg{width:100%;height:auto;display:block}
        .chart-meta{display:flex;justify-content:space-between;gap:1rem;align-items:end;margin-bottom:.85rem}
        .delta-up{color:var(--success)}
        .delta-down{color:#9f1239}
        .table-wrap{overflow:auto}
        table.metrics{width:100%;border-collapse:collapse}
        table.metrics th,table.metrics td{padding:.8rem .65rem;text-align:left;border-bottom:1px solid var(--line);white-space:nowrap}
        .flash{margin-bottom:1rem;padding:1rem 1.1rem;border-radius:18px;background:rgba(31,122,82,.12);border:1px solid rgba(31,122,82,.2);color:#155e43}
        .error{color:#9f1239;margin-top:.5rem;font-size:.95rem}
        @media (max-width:640px){.nav{flex-direction:column;align-items:stretch}.brand-lockup{justify-content:center}.brand-logo{width:60px;height:60px}.nav-links{width:100%}.nav-links a,.nav button{flex:1 1 auto;text-align:center}}
    </style>
</head>
<body>
    {{ $slot }}
</body>
</html>
