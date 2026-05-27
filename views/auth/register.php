<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse — Los Alpes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --page-bg:   #F1F5F9;
            --card-bg:   #ffffff;
            --brand-clr: #1E3A5F;
            --sub-clr:   #64748B;
            --title-clr: #0F172A;
            --label-clr: #334155;
            --input-bg:  #F8FAFC;
            --input-bd:  #E2E8F0;
            --input-clr: #0F172A;
            --alt-clr:   #64748B;
        }
        [data-theme="dark"] {
            --page-bg:   #111827;
            --card-bg:   #1f2937;
            --brand-clr: #93C5FD;
            --sub-clr:   rgba(255,255,255,.4);
            --title-clr: #f1f5f9;
            --label-clr: rgba(255,255,255,.6);
            --input-bg:  rgba(255,255,255,.06);
            --input-bd:  rgba(255,255,255,.12);
            --input-clr: #f1f5f9;
            --alt-clr:   rgba(255,255,255,.4);
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--page-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            transition: background .25s;
        }

        .auth-wrap { width: 100%; max-width: 440px; }

        .auth-brand { text-align: center; margin-bottom: 2rem; }
        .auth-brand-name { font-size: 1.8rem; font-weight: 900; color: var(--brand-clr); transition: color .25s; }
        .auth-brand-sub  { font-size: .9rem; color: var(--sub-clr); }

        .auth-card {
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: 0 4px 32px rgba(0,0,0,.15);
            padding: 2.5rem 2rem;
            transition: background .25s;
        }

        .auth-title { font-size: 1.3rem; font-weight: 900; color: var(--title-clr); margin-bottom: .3rem; }
        .auth-sub   { font-size: .88rem; color: var(--sub-clr); margin-bottom: 1.75rem; }

        label {
            display: block;
            font-size: .8rem;
            font-weight: 700;
            color: var(--label-clr);
            margin-bottom: .35rem;
            margin-top: 1rem;
        }
        input {
            width: 100%;
            padding: .75rem 1rem;
            border: 1.5px solid var(--input-bd);
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: .95rem;
            background: var(--input-bg);
            outline: none;
            color: var(--input-clr);
            transition: border-color .15s, background .25s, color .25s;
        }
        input:focus {
            border-color: #2563EB;
            background: var(--card-bg);
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }

        .btn-submit {
            display: block; width: 100%; padding: .9rem; margin-top: 1.5rem;
            background: #2563EB; color: #fff; border: none; border-radius: 12px;
            font-family: 'Nunito', sans-serif; font-size: 1rem; font-weight: 800;
            cursor: pointer; transition: background .2s;
        }
        .btn-submit:hover { background: #1D4ED8; }

        .auth-alt {
            text-align: center; margin-top: 1.25rem;
            font-size: .88rem; color: var(--alt-clr);
        }
        .auth-alt a { color: #2563EB; font-weight: 700; text-decoration: none; }
        .auth-alt a:hover { text-decoration: underline; }

        .error-box   { background: #FEF2F2; border: 1.5px solid #FECACA; color: #991B1B; border-radius: 10px; padding: .75rem 1rem; font-size: .88rem; margin-bottom: 1rem; }
        .success-box { background: #F0FDF4; border: 1.5px solid #BBF7D0; color: #166534; border-radius: 10px; padding: .75rem 1rem; font-size: .88rem; margin-bottom: 1rem; }
    </style>
    <script>
    (function() {
        var t = localStorage.getItem('alpes-theme') || 'dark';
        document.documentElement.setAttribute('data-theme', t);
    })();
    </script>
</head>
<body>
<div class="auth-wrap">
    <div class="auth-brand">
        <div class="auth-brand-name" style="display:flex;align-items:center;justify-content:center;gap:.5rem;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px;"><path d="M12 12A5 5 0 1 0 12 2a5 5 0 0 0 0 10z"/><path d="M12 12 L7 12 L12 22 L17 12 Z"/></svg>
            Los Alpes
        </div>
        <div class="auth-brand-sub">Heladería</div>
    </div>

    <div class="auth-card">
        <div class="auth-title">Crea tu cuenta</div>
        <div class="auth-sub">Regístrate para hacer pedidos</div>

        <?php if (!empty($error)): ?>
            <div class="error-box" style="display:flex;align-items:center;gap:.5rem;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; flex-shrink: 0;"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="success-box" style="display:flex;align-items:center;gap:.5rem;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; flex-shrink: 0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="index.php?page=register">
            <label>Nombre completo</label>
            <input type="text" name="nombre" placeholder="Tu nombre" required autocomplete="name">

            <label>Correo electrónico</label>
            <input type="email" name="correo" placeholder="tu@correo.com" required autocomplete="email">

            <label>Contraseña</label>
            <input type="password" name="contrasena" placeholder="Mínimo 6 caracteres" required minlength="6" autocomplete="new-password">

            <label>Confirmar contraseña</label>
            <input type="password" name="contrasena2" placeholder="Repite tu contraseña" required minlength="6">

            <button type="submit" class="btn-submit">Crear cuenta</button>
        </form>

        <div class="auth-alt">
            ¿Ya tienes cuenta? <a href="index.php?page=login">Inicia sesión</a>
        </div>
    </div>
</div>
</body>
</html>
