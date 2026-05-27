<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Los Alpes — Heladería</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    /* ── Tema oscuro (default) ── */
    :root {
        --blue: #2563EB;
        --sidebar-w: 230px;
        --sb-bg:       #1a1a2e;
        --sb-border:   rgba(255,255,255,.07);
        --sb-text:     rgba(255,255,255,.6);
        --sb-text-h:   #fff;
        --sb-hover:    rgba(255,255,255,.07);
        --sb-active:   #2563EB;
        --sb-section:  rgba(255,255,255,.35);
        --sb-logout-h: rgba(239,68,68,.12);
        --sb-logout-c: #FCA5A5;
        --main-bg:     #111827;
        --topbar-bg:   #1a1a2e;
        --topbar-bd:   rgba(255,255,255,.07);
        --search-bg:   rgba(255,255,255,.06);
        --search-bd:   rgba(255,255,255,.1);
        --text-main:   #f1f5f9;
        --text-muted:  rgba(255,255,255,.4);
        --input-color: #f1f5f9;

        /* ── Variables de contenido (dark) ── */
        --card-bg:        #1f2937;
        --card-border:    rgba(255,255,255,.07);
        --card-shadow:    0 2px 16px rgba(0,0,0,.3);
        --heading-color:  #f1f5f9;
        --body-color:     #cbd5e1;
        --muted-color:    rgba(255,255,255,.4);
        --label-color:    rgba(255,255,255,.55);
        --input-bg:       rgba(255,255,255,.06);
        --input-border:   rgba(255,255,255,.12);
        --input-focus-bg: rgba(255,255,255,.1);
        --table-head-bg:  rgba(255,255,255,.05);
        --table-head-txt: rgba(255,255,255,.45);
        --table-row-bd:   rgba(255,255,255,.05);
        --table-hover:    rgba(255,255,255,.03);
        --badge-bg:       rgba(255,255,255,.07);
        --badge-txt:      rgba(255,255,255,.5);
        --btn-sec-bg:     rgba(255,255,255,.07);
        --btn-sec-txt:    rgba(255,255,255,.7);
        --btn-sec-hover:  rgba(255,255,255,.12);
        --filter-btn-bg:  rgba(255,255,255,.05);
        --filter-btn-bd:  rgba(255,255,255,.1);
        --filter-btn-txt: rgba(255,255,255,.55);
        --stat-card-bg:   #1f2937;
        --info-block-bg:  rgba(255,255,255,.04);
        --prod-img-bg:    #111827;
        --prod-card-bg:   #1f2937;
        --prod-card-bd:   rgba(255,255,255,.07);
        --resumen-bg:     rgba(255,255,255,.04);
        --resumen-bd:     rgba(255,255,255,.08);
        --tab-border:     rgba(255,255,255,.1);
        --tab-active-txt: #60A5FA;
        --tab-txt:        rgba(255,255,255,.45);
        --alert-ok-bg:    rgba(16,185,129,.12);
        --alert-ok-bd:    rgba(16,185,129,.25);
        --alert-ok-txt:   #6EE7B7;
        --alert-err-bg:   rgba(239,68,68,.1);
        --alert-err-bd:   rgba(239,68,68,.2);
        --alert-err-txt:  #FCA5A5;
        --select-bg:      rgba(255,255,255,.06);
        --select-color:   #f1f5f9;
        --ck-card-bg:     #1f2937;
        --ck-step-todo:   rgba(255,255,255,.1);
        --ck-step-todo-txt: rgba(255,255,255,.3);
        --ck-divider:     rgba(255,255,255,.1);
        --option-btn-bg:  rgba(255,255,255,.05);
        --option-btn-bd:  rgba(255,255,255,.1);
        --option-btn-txt: rgba(255,255,255,.6);
        --prod-sum-bg:    rgba(255,255,255,.04);
        --prod-sum-bd:    rgba(255,255,255,.08);
        --topping-btn-bg: rgba(255,255,255,.04);
        --topping-btn-bd: rgba(255,255,255,.1);
        --topping-btn-txt: rgba(255,255,255,.6);
        --res-box-bg:     rgba(255,255,255,.04);
        --res-box-bd:     rgba(255,255,255,.08);
        --pago-opcion-bg: rgba(255,255,255,.04);
        --pago-opcion-bd: rgba(255,255,255,.1);
        --pago-icon-bg:   rgba(255,255,255,.07);
        --fac-body-bg:    #1f2937;
        --fac-row-bd:     rgba(255,255,255,.05);
        --fac-sub-bg:     rgba(255,255,255,.04);
        --fac-estado-bg:  rgba(251,191,36,.1);
        --fac-estado-txt: #FCD34D;
        --dir-box-bg:     rgba(37,99,235,.12);
        --dir-box-bd:     rgba(37,99,235,.25);
        --dir-text:       #93C5FD;
        --dir-sub:        #60A5FA;
        --empty-h3:       #cbd5e1;
        --pedido-card-bg: #1f2937;
        --pedido-card-bd: rgba(255,255,255,.07);
        --pedido-head-bd: rgba(255,255,255,.05);
        --pedido-num:     #f1f5f9;
        --pedido-fecha:   rgba(255,255,255,.35);
        --usu-card-bg:    #1f2937;
        --usu-card-bd:    rgba(255,255,255,.07);
        --usu-head-bd:    rgba(255,255,255,.05);
        --usu-title:      #f1f5f9;
        --rol-sel-bg:     rgba(255,255,255,.06);
        --rol-sel-color:  #f1f5f9;
        --form-input-bg:  rgba(255,255,255,.06);
        --form-input-bd:  rgba(255,255,255,.12);
        --form-input-clr: #f1f5f9;
        --edit-banner-bg: rgba(37,99,235,.12);
        --edit-banner-bd: rgba(37,99,235,.25);
        --edit-banner-txt:#93C5FD;
        --cat-tab-bg:     rgba(255,255,255,.05);
        --cat-tab-bd:     rgba(255,255,255,.1);
        --cat-tab-txt:    rgba(255,255,255,.55);
        --cat-banner-bg:  rgba(37,99,235,.13);
        --cat-banner-bd:  rgba(37,99,235,.28);
        --cat-banner-name:#93C5FD;
        --cat-banner-desc:rgba(255,255,255,.4);
        --item-icon-bg:   rgba(255,255,255,.06);
        --item-name:      #f1f5f9;
        --item-qty:       rgba(255,255,255,.4);
        --qty-btn-bg:     rgba(255,255,255,.06);
        --qty-btn-bd:     rgba(255,255,255,.1);
        --qty-input-bg:   rgba(255,255,255,.04);
        --qty-input-bd:   rgba(255,255,255,.1);
        --carrito-vacio-h:#f1f5f9;
        --carrito-vacio-p:rgba(255,255,255,.4);
        --factura-mini-bg:#1f2937;
        --factura-mini-bd:rgba(255,255,255,.07);
        --cb-messages-bg: #111827;
        --cb-bot-bubble:  #1f2937;
        --cb-bot-txt:     #f1f5f9;
        --cb-sug-bg:      #1f2937;
        --cb-sug-bd:      rgba(255,255,255,.07);
        --cb-sug-btn-bg:  rgba(255,255,255,.05);
        --cb-sug-btn-bd:  rgba(255,255,255,.1);
        --cb-sug-btn-txt: rgba(255,255,255,.6);
        --cb-input-row-bg:#1f2937;
        --cb-input-row-bd:rgba(255,255,255,.07);
        --cb-input-bg:    rgba(255,255,255,.06);
        --cb-input-bd:    rgba(255,255,255,.12);
        --cb-input-clr:   #f1f5f9;
        --cb-window-bg:   #1a1a2e;
    }
    /* ── Tema claro ── */
    [data-theme="light"] {
        --sb-bg:       #1e293b;
        --sb-border:   rgba(255,255,255,.08);
        --sb-text:     rgba(255,255,255,.65);
        --sb-text-h:   #fff;
        --sb-hover:    rgba(255,255,255,.08);
        --sb-active:   #2563EB;
        --sb-section:  rgba(255,255,255,.35);
        --sb-logout-h: rgba(239,68,68,.12);
        --sb-logout-c: #FCA5A5;
        --main-bg:     #F1F5F9;
        --topbar-bg:   #FFFFFF;
        --topbar-bd:   #E2E8F0;
        --search-bg:   #F8FAFC;
        --search-bd:   #E2E8F0;
        --text-main:   #0F172A;
        --text-muted:  #64748B;
        --input-color: #0F172A;

        /* ── Variables de contenido (light) ── */
        --card-bg:        #ffffff;
        --card-border:    #E2E8F0;
        --card-shadow:    0 2px 16px rgba(0,0,0,.06);
        --heading-color:  #0F172A;
        --body-color:     #334155;
        --muted-color:    #64748B;
        --label-color:    #334155;
        --input-bg:       #F8FAFC;
        --input-border:   #E2E8F0;
        --input-focus-bg: #ffffff;
        --table-head-bg:  #F8FAFC;
        --table-head-txt: #64748B;
        --table-row-bd:   #F1F5F9;
        --table-hover:    #FAFBFF;
        --badge-bg:       #F1F5F9;
        --badge-txt:      #64748B;
        --btn-sec-bg:     #F1F5F9;
        --btn-sec-txt:    #334155;
        --btn-sec-hover:  #E2E8F0;
        --filter-btn-bg:  #F8FAFC;
        --filter-btn-bd:  #E2E8F0;
        --filter-btn-txt: #475569;
        --stat-card-bg:   #ffffff;
        --info-block-bg:  #F8FAFC;
        --prod-img-bg:    #F1F5F9;
        --prod-card-bg:   #ffffff;
        --prod-card-bd:   #E2E8F0;
        --resumen-bg:     #F8FAFC;
        --resumen-bd:     #E2E8F0;
        --tab-border:     #E2E8F0;
        --tab-active-txt: #2563EB;
        --tab-txt:        #64748B;
        --alert-ok-bg:    #D1FAE5;
        --alert-ok-bd:    #A7F3D0;
        --alert-ok-txt:   #065F46;
        --alert-err-bg:   #FEF2F2;
        --alert-err-bd:   #FECACA;
        --alert-err-txt:  #991B1B;
        --select-bg:      #F8FAFC;
        --select-color:   #0F172A;
        --ck-card-bg:     #ffffff;
        --ck-step-todo:   #E2E8F0;
        --ck-step-todo-txt:#94A3B8;
        --ck-divider:     #E2E8F0;
        --option-btn-bg:  #ffffff;
        --option-btn-bd:  #E2E8F0;
        --option-btn-txt: #334155;
        --prod-sum-bg:    #F8FAFC;
        --prod-sum-bd:    #E2E8F0;
        --topping-btn-bg: #ffffff;
        --topping-btn-bd: #E2E8F0;
        --topping-btn-txt:#334155;
        --res-box-bg:     #F8FAFC;
        --res-box-bd:     #E2E8F0;
        --pago-opcion-bg: #ffffff;
        --pago-opcion-bd: #E2E8F0;
        --pago-icon-bg:   #F1F5F9;
        --fac-body-bg:    #ffffff;
        --fac-row-bd:     #F8FAFC;
        --fac-sub-bg:     #F8FAFC;
        --fac-estado-bg:  #FEF3C7;
        --fac-estado-txt: #92400E;
        --dir-box-bg:     #EFF6FF;
        --dir-box-bd:     #BFDBFE;
        --dir-text:       #1D4ED8;
        --dir-sub:        #3B82F6;
        --empty-h3:       #334155;
        --pedido-card-bg: #ffffff;
        --pedido-card-bd: #E2E8F0;
        --pedido-head-bd: #F1F5F9;
        --pedido-num:     #0F172A;
        --pedido-fecha:   #94A3B8;
        --usu-card-bg:    #ffffff;
        --usu-card-bd:    #E2E8F0;
        --usu-head-bd:    #F1F5F9;
        --usu-title:      #0F172A;
        --rol-sel-bg:     #ffffff;
        --rol-sel-color:  #334155;
        --form-input-bg:  #ffffff;
        --form-input-bd:  #E2E8F0;
        --form-input-clr: #0F172A;
        --edit-banner-bg: #EFF6FF;
        --edit-banner-bd: #BFDBFE;
        --edit-banner-txt:#1D4ED8;
        --cat-tab-bg:     #F1F5F9;
        --cat-tab-bd:     #E2E8F0;
        --cat-tab-txt:    #475569;
        --cat-banner-bg:  rgba(37,99,235,.08);
        --cat-banner-bd:  rgba(37,99,235,.2);
        --cat-banner-name:#1D4ED8;
        --cat-banner-desc:#64748B;
        --item-icon-bg:   #F1F5F9;
        --item-name:      #0F172A;
        --item-qty:       #64748B;
        --qty-btn-bg:     #ffffff;
        --qty-btn-bd:     #E2E8F0;
        --qty-input-bg:   #F8FAFC;
        --qty-input-bd:   #E2E8F0;
        --carrito-vacio-h:#0F172A;
        --carrito-vacio-p:#64748B;
        --factura-mini-bg:#F8FAFC;
        --factura-mini-bd:#E2E8F0;
        --cb-messages-bg: #F8FAFC;
        --cb-bot-bubble:  #ffffff;
        --cb-bot-txt:     #0F172A;
        --cb-sug-bg:      #ffffff;
        --cb-sug-bd:      #F1F5F9;
        --cb-sug-btn-bg:  #F8FAFC;
        --cb-sug-btn-bd:  #E2E8F0;
        --cb-sug-btn-txt: #334155;
        --cb-input-row-bg:#ffffff;
        --cb-input-row-bd:#F1F5F9;
        --cb-input-bg:    #F8FAFC;
        --cb-input-bd:    #E2E8F0;
        --cb-input-clr:   #0F172A;
        --cb-window-bg:   #ffffff;
    }

    html, body { height: 100%; font-family: 'Nunito', sans-serif; background: var(--main-bg); color: var(--text-main); transition: background .25s, color .25s; }
    .layout { display: flex; min-height: 100vh; }

    /* ── Sidebar ── */
    .sidebar {
        width: var(--sidebar-w); background: var(--sb-bg);
        display: flex; flex-direction: column; flex-shrink: 0;
        position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto; z-index: 100;
        border-right: 1px solid var(--sb-border);
        transition: background .25s;
    }
    .sidebar-brand {
        display: flex; align-items: center; gap: .75rem;
        padding: 1.3rem 1.1rem 1rem;
        border-bottom: 1px solid var(--sb-border);
    }
    .sidebar-brand img { width: 36px; height: 36px; border-radius: 9px; object-fit: contain; background: rgba(255,255,255,.1); padding: 4px; }
    .sidebar-brand-name { font-size: .98rem; font-weight: 800; color: #fff; }
    .sidebar-brand-sub  { font-size: .7rem; color: var(--sb-section); }

    .sidebar-user {
        display: flex; align-items: center; gap: .7rem;
        padding: .85rem 1.1rem; border-bottom: 1px solid var(--sb-border);
    }
    .sidebar-avatar {
        width: 34px; height: 34px; border-radius: 50%;
        background: var(--blue); color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: .8rem; font-weight: 800; flex-shrink: 0; letter-spacing: .02em;
    }
    .sidebar-user-name { font-size: .82rem; font-weight: 700; color: #fff; line-height: 1.2; }
    .sidebar-user-role { font-size: .68rem; color: var(--sb-section); text-transform: capitalize; }

    .sidebar-nav { padding: .8rem .6rem; flex: 1; }
    .sidebar-section {
        font-size: .62rem; font-weight: 800; color: var(--sb-section);
        letter-spacing: .1em; text-transform: uppercase;
        padding: .85rem .6rem .2rem;
    }
    .sidebar-link {
        display: flex; align-items: center; gap: .65rem;
        padding: .62rem .85rem; border-radius: 9px; margin-bottom: .08rem;
        color: var(--sb-text); text-decoration: none; font-size: .86rem; font-weight: 600;
        transition: background .15s, color .15s;
    }
    .sidebar-link:hover  { background: var(--sb-hover); color: var(--sb-text-h); }
    .sidebar-link.active { background: var(--sb-active); color: #fff; }
    .sidebar-link svg    { width: 17px; height: 17px; flex-shrink: 0; }

    .sidebar-footer { padding: .8rem .6rem; border-top: 1px solid var(--sb-border); }
    .sidebar-logout {
        display: flex; align-items: center; gap: .65rem;
        padding: .62rem .85rem; border-radius: 9px;
        color: var(--sb-text); text-decoration: none; font-size: .86rem; font-weight: 600;
        transition: background .15s, color .15s;
    }
    .sidebar-logout:hover { background: var(--sb-logout-h); color: var(--sb-logout-c); }
    .sidebar-logout svg  { width: 17px; height: 17px; flex-shrink: 0; }

    /* ── Main ── */
    .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
    .topbar {
        background: var(--topbar-bg); border-bottom: 1px solid var(--topbar-bd);
        padding: .8rem 1.75rem; display: flex; align-items: center; justify-content: space-between;
        position: sticky; top: 0; z-index: 50; transition: background .25s, border-color .25s;
    }
    .topbar-search {
        display: flex; align-items: center; gap: .6rem;
        background: var(--search-bg); border: 1px solid var(--search-bd);
        border-radius: 10px; padding: .42rem .9rem; width: 270px;
        transition: background .25s, border-color .25s;
    }
    .topbar-search svg   { width: 15px; height: 15px; color: var(--text-muted); flex-shrink: 0; }
    .topbar-search input { border: none; background: transparent; outline: none; font-family: 'Nunito', sans-serif; font-size: .87rem; width: 100%; color: var(--input-color); }
    .topbar-search input::placeholder { color: var(--text-muted); }
    .topbar-actions { display: flex; align-items: center; gap: .85rem; }
    .topbar-cart {
        display: flex; align-items: center; gap: .45rem; padding: .48rem .95rem;
        background: var(--blue); color: #fff; border-radius: 9px;
        text-decoration: none; font-size: .84rem; font-weight: 700;
    }

    /* ── Toggle tema ── */
    #theme-toggle {
        width: 38px; height: 38px; border-radius: 9px; border: 1px solid var(--search-bd);
        background: var(--search-bg); cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background .15s, border-color .15s; flex-shrink: 0;
    }
    #theme-toggle:hover { background: var(--sb-hover); }
    #theme-toggle svg { width: 18px; height: 18px; color: var(--text-muted); }

    .page-content { padding: 1.75rem 2rem; flex: 1; }
    </style>
</head>
<body>
<div class="layout">

<!-- ── Sidebar ── -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="img/logo.png" alt="Logo Los Alpes">
        <div>
            <div class="sidebar-brand-name">Los Alpes</div>
            <div class="sidebar-brand-sub">Heladería</div>
        </div>
    </div>

    <?php if (isLoggedIn()): ?>
    <div class="sidebar-user">
        <div class="sidebar-avatar"><?= strtoupper(substr(getUserName() ?? 'U', 0, 2)) ?></div>
        <div>
            <div class="sidebar-user-name"><?= htmlspecialchars(getUserName()) ?></div>
            <div class="sidebar-user-role"><?= htmlspecialchars(getUserRole()) ?></div>
        </div>
    </div>
    <?php endif; ?>

    <nav class="sidebar-nav">
        <?php $rol = getUserRole(); $pg = $_GET['page'] ?? 'home'; ?>

        <?php if ($rol !== 'domiciliario'): ?>
        <div class="sidebar-section">Menú</div>
        <a href="index.php?page=catalogo" class="sidebar-link <?= in_array($pg, ['catalogo','home','productos_catalogo']) ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            <?= $rol === 'administrador' ? 'Ver catálogo' : 'Catálogo' ?>
        </a>
        <?php endif; ?>

        <?php if ($rol === 'cliente'): ?>
            <a href="index.php?page=carrito" class="sidebar-link <?= $pg === 'carrito' ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                Mi Carrito
            </a>
            <a href="index.php?page=cliente_pedidos" class="sidebar-link <?= $pg === 'cliente_pedidos' ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="9" y1="7" x2="15" y2="7"/><line x1="9" y1="11" x2="15" y2="11"/><line x1="9" y1="15" x2="13" y2="15"/></svg>
                Mis Pedidos
            </a>
        <?php endif; ?>

        <?php if ($rol === 'domiciliario'): ?>
            <div class="sidebar-section">Mis Entregas</div>
            <a href="index.php?page=domiciliario_pedidos" class="sidebar-link <?= $pg === 'domiciliario_pedidos' ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                Pedidos asignados
            </a>
        <?php endif; ?>

        <?php if ($rol === 'administrador'): ?>
            <?php
            // Contar notificaciones de stock crítico no vistas (últimas 48h)
            $notifCount = 0;
            try {
                $dbNotif = (new Database())->conectar();
                $stmtN = $dbNotif->prepare("
                    SELECT COUNT(*) FROM notificacion
                    WHERE idpersona = :idp AND tipo_stock_minimo = 1
                      AND fecha >= NOW() - INTERVAL 48 HOUR
                ");
                $stmtN->execute([':idp' => getUserId()]);
                $notifCount = (int)$stmtN->fetchColumn();
            } catch (Exception $e) { $notifCount = 0; }
            ?>
            <div class="sidebar-section">Administración</div>
            <a href="index.php?page=admin_productos" class="sidebar-link <?= $pg === 'admin_productos' ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                Productos
            </a>
            <a href="index.php?page=admin_inventario" class="sidebar-link <?= $pg === 'admin_inventario' ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Inventario
            </a>
            <a href="index.php?page=admin_ventas" class="sidebar-link <?= $pg === 'admin_ventas' ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                Ventas
            </a>
            <a href="index.php?page=admin_proveedores" class="sidebar-link <?= $pg === 'admin_proveedores' ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                Proveedores
            </a>
            <a href="index.php?page=admin_catalogo" class="sidebar-link <?= $pg === 'admin_catalogo' ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
                Categorías
            </a>
            <a href="index.php?page=admin_usuarios" class="sidebar-link <?= $pg === 'admin_usuarios' ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Usuarios
            </a>
            <div class="sidebar-section">Análisis</div>
            <a href="index.php?page=admin_reportes" class="sidebar-link <?= $pg === 'admin_reportes' ? 'active' : '' ?>">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/><line x1="2" y1="20" x2="22" y2="20"/></svg>
                Reportes
                <?php if ($notifCount > 0): ?>
                    <span style="margin-left:auto;background:#EF4444;color:#fff;font-size:.62rem;font-weight:800;padding:.15rem .45rem;border-radius:99px;line-height:1.4"><?= $notifCount ?></span>
                <?php endif; ?>
            </a>
        <?php endif; ?>

        <?php if (!isLoggedIn()): ?>
            <div class="sidebar-section">Cuenta</div>
            <a href="index.php?page=login" class="sidebar-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Iniciar sesión
            </a>
            <a href="index.php?page=register" class="sidebar-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                Registrarse
            </a>
        <?php endif; ?>
    </nav>

    <?php if (isLoggedIn()): ?>
    <div class="sidebar-footer">
        <a href="index.php?page=logout" class="sidebar-logout">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Cerrar sesión
        </a>
    </div>
    <?php endif; ?>
</aside>

<!-- ── Main ── -->
<div class="main">
    <div class="topbar">
        <div class="topbar-search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" placeholder="Buscar productos...">
        </div>
        <div class="topbar-actions">
            <!-- Toggle dark/light -->
            <button id="theme-toggle" onclick="toggleTheme()" title="Cambiar tema">
                <svg id="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                <svg id="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
            </button>
            <?php if (isLoggedIn() && getUserRole() === 'administrador' && !empty($notifCount)): ?>
            <!-- Campana de alertas de stock -->
            <div style="position:relative">
                <button id="notif-btn" onclick="toggleNotifPanel()" title="Alertas de stock" style="width:38px;height:38px;border-radius:9px;border:1px solid var(--search-bd);background:var(--search-bg);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .15s;flex-shrink:0;position:relative;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <span style="position:absolute;top:-3px;right:-3px;background:#EF4444;color:#fff;font-size:.58rem;font-weight:800;width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center;"><?= $notifCount ?></span>
                </button>
                <div id="notif-panel" style="display:none;position:absolute;top:calc(100% + 8px);right:0;width:320px;background:var(--card-bg);border:1px solid var(--card-border);border-radius:14px;box-shadow:0 8px 32px rgba(0,0,0,.25);z-index:200;overflow:hidden;">
                    <div style="padding:.85rem 1rem;border-bottom:1px solid var(--card-border);display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:.88rem;font-weight:800;color:var(--heading-color)">⚠️ Alertas de stock</span>
                        <a href="index.php?page=admin_reportes" style="font-size:.75rem;color:#2563EB;font-weight:700;text-decoration:none;">Ver todo</a>
                    </div>
                    <div style="max-height:280px;overflow-y:auto;">
                        <?php
                        try {
                            $dbAlerts = (new Database())->conectar();
                            $stmtA = $dbAlerts->prepare("
                                SELECT n.mensaje, n.fecha, i.nombre AS insumo, i.stock_actual, i.unidad_medida
                                FROM notificacion n
                                LEFT JOIN insumo i ON n.idinsumo = i.idinsumo
                                WHERE n.idpersona = :idp AND n.tipo_stock_minimo = 1
                                  AND n.fecha >= NOW() - INTERVAL 48 HOUR
                                ORDER BY n.fecha DESC LIMIT 10
                            ");
                            $stmtA->execute([':idp' => getUserId()]);
                            $alertas = $stmtA->fetchAll(PDO::FETCH_ASSOC);
                        } catch (Exception $e) { $alertas = []; }
                        ?>
                        <?php foreach ($alertas as $al): ?>
                        <div style="padding:.75rem 1rem;border-bottom:1px solid var(--table-row-bd);display:flex;gap:.65rem;align-items:flex-start;">
                            <div style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:.82rem;font-weight:700;color:var(--heading-color);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= htmlspecialchars($al['insumo'] ?? '') ?></div>
                                <div style="font-size:.75rem;color:#F59E0B;font-weight:600;">Stock: <?= $al['stock_actual'] ?> <?= htmlspecialchars($al['unidad_medida'] ?? '') ?></div>
                                <div style="font-size:.7rem;color:var(--muted-color);"><?= date('d/m H:i', strtotime($al['fecha'])) ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php if (empty($alertas)): ?>
                            <div style="padding:1.5rem;text-align:center;color:var(--muted-color);font-size:.85rem;">Sin alertas recientes</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if (isLoggedIn() && getUserRole() === 'cliente'): ?>
                <a href="index.php?page=carrito" class="topbar-cart">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    Carrito
                </a>
            <?php elseif (!isLoggedIn()): ?>
                <a href="index.php?page=login" class="topbar-cart">Ingresar</a>
            <?php endif; ?>
        </div>
    </div>
    <div class="page-content">
        <?= $content ?>
    </div>
</div>

</div><!-- /.layout -->

<script>
// ── Toggle dark / light ──────────────────────────────────────────
(function() {
    var saved = localStorage.getItem('alpes-theme') || 'dark';
    document.documentElement.setAttribute('data-theme', saved);
    updateThemeIcon(saved);
})();

function toggleTheme() {
    var current = document.documentElement.getAttribute('data-theme');
    var next    = current === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', next);
    localStorage.setItem('alpes-theme', next);
    updateThemeIcon(next);
}

function updateThemeIcon(theme) {
    var moon = document.getElementById('icon-moon');
    var sun  = document.getElementById('icon-sun');
    if (!moon || !sun) return;
    if (theme === 'dark') {
        moon.style.display = 'block';
        sun.style.display  = 'none';
    } else {
        moon.style.display = 'none';
        sun.style.display  = 'block';
    }
}

function toggleNotifPanel() {
    var panel = document.getElementById('notif-panel');
    if (!panel) return;
    panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    var btn   = document.getElementById('notif-btn');
    var panel = document.getElementById('notif-panel');
    if (!btn || !panel) return;
    if (!btn.contains(e.target) && !panel.contains(e.target)) {
        panel.style.display = 'none';
    }
});
</script>

<?php if (isLoggedIn()): ?>
<style>
#chatbot-fab {
    position:fixed; bottom:1.5rem; right:1.5rem; z-index:9999;
    width:54px; height:54px; border-radius:50%;
    background:linear-gradient(135deg,#2563EB,#1E3A5F);
    color:#fff; border:none; cursor:pointer;
    box-shadow:0 4px 20px rgba(37,99,235,.4);
    display:flex; align-items:center; justify-content:center;
    transition:transform .2s,box-shadow .2s;
}
#chatbot-fab:hover { transform:scale(1.1); }
#chatbot-fab .fab-badge {
    position:absolute; top:-2px; right:-2px;
    width:17px; height:17px; background:#EF4444; border-radius:50%;
    font-size:.62rem; font-weight:800; display:none;
    align-items:center; justify-content:center; color:#fff;
}
#chatbot-window {
    position:fixed; bottom:5rem; right:1.5rem; z-index:9998;
    width:350px; max-height:510px;
    background:var(--cb-window-bg); border-radius:18px;
    box-shadow:0 8px 40px rgba(0,0,0,.25);
    display:none; flex-direction:column; overflow:hidden;
    font-family:'Nunito',sans-serif;
    transition: background .25s;
}
#chatbot-window.open { display:flex; }
.cb-head { background:linear-gradient(135deg,#1E3A5F,#2563EB); padding:.85rem 1rem; display:flex; align-items:center; gap:.7rem; }
.cb-head-avatar { width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,.2); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.cb-head-info { flex:1; }
.cb-head-name { font-size:.88rem; font-weight:800; color:#fff; }
.cb-head-status { font-size:.7rem; color:rgba(255,255,255,.7); display:flex; align-items:center; gap:.3rem; }
.cb-head-status::before { content:''; width:6px; height:6px; border-radius:50%; background:#4ADE80; display:inline-block; }
.cb-close { background:none; border:none; color:rgba(255,255,255,.7); cursor:pointer; font-size:1rem; }
.cb-close:hover { color:#fff; }
.cb-messages { flex:1; overflow-y:auto; padding:.9rem; display:flex; flex-direction:column; gap:.6rem; background:var(--cb-messages-bg); transition:background .25s; }
.cb-messages::-webkit-scrollbar { width:3px; }
.cb-messages::-webkit-scrollbar-thumb { background:var(--card-border); border-radius:3px; }
.cb-msg { display:flex; gap:.45rem; align-items:flex-end; }
.cb-msg.bot { justify-content:flex-start; }
.cb-msg.user { justify-content:flex-end; }
.cb-bubble { max-width:82%; padding:.55rem .85rem; border-radius:15px; font-size:.83rem; line-height:1.5; word-break:break-word; }
.cb-msg.bot .cb-bubble { background:var(--cb-bot-bubble); color:var(--cb-bot-txt); border-bottom-left-radius:3px; box-shadow:0 1px 4px rgba(0,0,0,.12); transition:background .25s,color .25s; }
.cb-msg.user .cb-bubble { background:#2563EB; color:#fff; border-bottom-right-radius:3px; }
.cb-avatar-bot { width:26px; height:26px; border-radius:50%; background:var(--edit-banner-bg); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.cb-typing { display:flex; gap:4px; padding:.45rem .7rem; }
.cb-typing span { width:6px; height:6px; border-radius:50%; background:var(--muted-color); animation:cbBounce .9s infinite; }
.cb-typing span:nth-child(2) { animation-delay:.15s; }
.cb-typing span:nth-child(3) { animation-delay:.3s; }
@keyframes cbBounce { 0%,60%,100%{transform:translateY(0)} 30%{transform:translateY(-5px)} }
.cb-suggestions { display:flex; flex-wrap:wrap; gap:.35rem; padding:.55rem .9rem; border-top:1px solid var(--cb-sug-bd); background:var(--cb-sug-bg); transition:background .25s,border-color .25s; }
.cb-sug-btn { padding:.28rem .7rem; border-radius:20px; border:1.5px solid var(--cb-sug-btn-bd); background:var(--cb-sug-btn-bg); font-family:'Nunito',sans-serif; font-size:.73rem; font-weight:700; color:var(--cb-sug-btn-txt); cursor:pointer; transition:background .15s,border-color .15s,color .15s; }
.cb-sug-btn:hover { background:#EFF6FF; border-color:#2563EB; color:#2563EB; }
.cb-input-row { display:flex; gap:.45rem; padding:.7rem .9rem; border-top:1px solid var(--cb-input-row-bd); background:var(--cb-input-row-bg); transition:background .25s,border-color .25s; }
.cb-input { flex:1; padding:.5rem .8rem; border:1.5px solid var(--cb-input-bd); border-radius:11px; font-family:'Nunito',sans-serif; font-size:.86rem; outline:none; color:var(--cb-input-clr); background:var(--cb-input-bg); transition:border-color .15s,background .25s,color .25s; }
.cb-input:focus { border-color:#2563EB; background:var(--input-focus-bg); }
.cb-send { width:36px; height:36px; border-radius:9px; background:#2563EB; color:#fff; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; font-size:.95rem; transition:background .15s; flex-shrink:0; }
.cb-send:hover { background:#1D4ED8; }
</style>

<button id="chatbot-fab" onclick="cbToggle()" title="Asistente Los Alpes">
    <img src="img/logo.png" alt="Los Alpes" style="width:30px;height:30px;object-fit:contain;border-radius:50%;">
    <span class="fab-badge" id="cbBadge">1</span>
</button>

<div id="chatbot-window">
    <div class="cb-head">
        <div class="cb-head-avatar"><img src="img/logo.png" alt="" style="width:26px;height:26px;object-fit:contain;border-radius:50%;"></div>
        <div class="cb-head-info">
            <div class="cb-head-name">Asistente Los Alpes</div>
            <div class="cb-head-status">En línea</div>
        </div>
        <button class="cb-close" onclick="cbToggle()">✕</button>
    </div>
    <div class="cb-messages" id="cbMessages">
        <div class="cb-msg bot">
            <div class="cb-avatar-bot"><img src="img/logo.png" alt="" style="width:18px;height:18px;object-fit:contain;border-radius:50%;"></div>
            <div class="cb-bubble">¡Hola, <strong><?= htmlspecialchars(getUserName() ?? '') ?></strong>! 👋<br>Soy el asistente de <strong>Los Alpes</strong>. ¿En qué te puedo ayudar?</div>
        </div>
    </div>
    <div class="cb-suggestions" id="cbSugerencias">
        <?php $rol = getUserRole(); ?>
        <?php if ($rol === 'cliente'): ?>
            <button class="cb-sug-btn" onclick="cbEnviar('¿Cómo hago un pedido?')">¿Cómo pedir?</button>
            <button class="cb-sug-btn" onclick="cbEnviar('¿Cuáles son los métodos de pago?')">Métodos de pago</button>
            <button class="cb-sug-btn" onclick="cbEnviar('¿Cuánto cuesta el domicilio?')">Domicilio</button>
            <button class="cb-sug-btn" onclick="cbEnviar('¿Cómo veo mis pedidos?')">Mis pedidos</button>
        <?php elseif ($rol === 'administrador'): ?>
            <button class="cb-sug-btn" onclick="cbEnviar('¿Cómo agrego un producto?')">Agregar producto</button>
            <button class="cb-sug-btn" onclick="cbEnviar('¿Cómo gestiono el inventario?')">Inventario</button>
            <button class="cb-sug-btn" onclick="cbEnviar('¿Cómo cambio el estado de un pedido?')">Ventas</button>
        <?php elseif ($rol === 'domiciliario'): ?>
            <button class="cb-sug-btn" onclick="cbEnviar('¿Cómo marco un pedido como entregado?')">Marcar entregado</button>
            <button class="cb-sug-btn" onclick="cbEnviar('¿Cómo veo mis pedidos asignados?')">Mis pedidos</button>
        <?php endif; ?>
        <button class="cb-sug-btn" onclick="cbEnviar('¿Qué productos tienen?')">Productos</button>
    </div>
    <div class="cb-input-row">
        <input type="text" class="cb-input" id="cbInput" placeholder="Escribe tu pregunta..." onkeydown="if(event.key==='Enter') cbEnviar()">
        <button class="cb-send" onclick="cbEnviar()">➤</button>
    </div>
</div>

<script>
var cbAbierto = false;
function cbToggle() {
    cbAbierto = !cbAbierto;
    var win = document.getElementById('chatbot-window');
    var badge = document.getElementById('cbBadge');
    if (cbAbierto) { win.classList.add('open'); badge.style.display='none'; document.getElementById('cbInput').focus(); }
    else { win.classList.remove('open'); }
}
function cbEnviar(textoFijo) {
    var input = document.getElementById('cbInput');
    var texto = textoFijo || input.value.trim();
    if (!texto) return;
    cbAgregarMensaje(texto, 'user');
    input.value = '';
    document.getElementById('cbSugerencias').style.display = 'none';
    var typingId = cbMostrarTyping();
    var fd = new FormData();
    fd.append('mensaje', texto);
    fetch('index.php?page=chatbot_responder', { method:'POST', body:fd })
        .then(function(r){ return r.json(); })
        .then(function(data) { cbQuitarTyping(typingId); cbAgregarMensaje(data.respuesta || 'Error.', 'bot'); })
        .catch(function() { cbQuitarTyping(typingId); cbAgregarMensaje('Error de conexión.', 'bot'); });
}
function cbAgregarMensaje(texto, tipo) {
    var msgs = document.getElementById('cbMessages');
    var div = document.createElement('div');
    div.className = 'cb-msg ' + tipo;
    var html = tipo === 'bot' ? '<div class="cb-avatar-bot"><img src="img/logo.png" alt="" style="width:18px;height:18px;object-fit:contain;border-radius:50%;"></div>' : '';
    html += '<div class="cb-bubble">' + texto.replace(/\n/g,'<br>') + '</div>';
    div.innerHTML = html;
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
}
function cbMostrarTyping() {
    var msgs = document.getElementById('cbMessages');
    var div = document.createElement('div');
    div.className = 'cb-msg bot';
    div.id = 'cb-t-' + Date.now();
    div.innerHTML = '<div class="cb-avatar-bot"><img src="img/logo.png" alt="" style="width:18px;height:18px;object-fit:contain;border-radius:50%;"></div><div class="cb-bubble"><div class="cb-typing"><span></span><span></span><span></span></div></div>';
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
    return div.id;
}
function cbQuitarTyping(id) { var el = document.getElementById(id); if (el) el.remove(); }
setTimeout(function() { if (!cbAbierto) { var b = document.getElementById('cbBadge'); if(b) b.style.display='flex'; } }, 3000);
</script>
<?php endif; ?>

</body>
</html>
