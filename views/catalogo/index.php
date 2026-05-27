<?php
if (!class_exists('Database')) {
    require_once __DIR__ . '/../../config/database.php';
}

$categorias = [];
$productos  = [];
$catActiva  = null;
$db_cat     = null;

try {
    $db_cat     = (new Database())->conectar();
    $categorias = $db_cat->query("SELECT * FROM catalogo ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $categorias = [];
}

// ── Icono SVG por categoría (para tabs y banner) ────────────────────────────
$_getIconSvg = function(string $nombre): string {
    $n = strtolower($nombre);

    // Canastas
    if (str_contains($n, 'canasta')) return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>';
    // Ensaladas / frutas
    if (str_contains($n, 'ensalada')) return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 100 20A10 10 0 0012 2z"/><path d="M12 2c0 5.523-4.477 10-10 10"/><path d="M12 2c0 5.523 4.477 10 10 10"/></svg>';
    // Malteadas / bebidas
    if (str_contains($n, 'malteada')) return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2h8l1 10H7L8 2z"/><path d="M7 12l1 8a2 2 0 002 2h4a2 2 0 002-2l1-8"/><line x1="10" y1="7" x2="14" y2="7"/></svg>';
    // Waffles
    if (str_contains($n, 'waffle')) return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="3"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/></svg>';
    // Yogures / helado
    if (str_contains($n, 'yogur') || str_contains($n, 'helado')) return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2C8.686 2 6 4.686 6 8c0 2.21 1.13 4.16 2.84 5.29L10 22h4l1.16-8.71C16.87 12.16 18 10.21 18 8c0-3.314-2.686-6-6-6z"/></svg>';
    // Default
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M8 14l-2 8h12l-2-8"/></svg>';
};

// ── Icono SVG por producto (más específico) ─────────────────────────────────
$_getProdIconSvg = function(string $nombre, string $cat) use ($_getIconSvg): string {
    $n = strtolower($nombre);
    $c = strtolower($cat);

    // Waffles específicos
    if (str_contains($c, 'waffle')) {
        if (str_contains($n, 'choco') || str_contains($n, 'nutella') || str_contains($n, 'kinder')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="3"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/></svg>';
        }
        if (str_contains($n, 'fresa') || str_contains($n, 'fruta') || str_contains($n, 'mango')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2C8 2 4 6 4 10c0 5 8 12 8 12s8-7 8-12c0-4-4-8-8-8z"/><circle cx="12" cy="10" r="3"/></svg>';
        }
        return $_getIconSvg($cat);
    }

    // Malteadas
    if (str_contains($c, 'malteada')) {
        if (str_contains($n, 'cafe') || str_contains($n, 'capuchino')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8h1a4 4 0 010 8h-1"/><path d="M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>';
        }
        return $_getIconSvg($cat);
    }

    // Canastas específicas
    if (str_contains($c, 'canasta')) {
        if (str_contains($n, 'chocorramo') || str_contains($n, 'chocolat') || str_contains($n, 'oreo')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>';
        }
        if (str_contains($n, 'fresa') || str_contains($n, 'fresura') || str_contains($n, 'acida') || str_contains($n, 'ácida')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2C8 2 4 6 4 10c0 5 8 12 8 12s8-7 8-12c0-4-4-8-8-8z"/><circle cx="12" cy="10" r="3"/></svg>';
        }
        return $_getIconSvg($cat);
    }

    // Yogures
    if (str_contains($c, 'yogur')) {
        if (str_contains($n, 'moon ice')) {
            return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>';
        }
        return $_getIconSvg($cat);
    }

    // Ensaladas
    if (str_contains($c, 'ensalada')) {
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2C8 2 4 6 4 10c0 5 8 12 8 12s8-7 8-12c0-4-4-8-8-8z"/><circle cx="12" cy="10" r="3"/></svg>';
    }

    return $_getIconSvg($cat);
};

// Tab emoji logic removed in favor of elegant inline SVGs

// Categoría activa
$idActivo = (int)($_GET['idcatalogo'] ?? 0);
if (!$idActivo && !empty($categorias)) {
    $idActivo = (int)$categorias[0]['idcatalogo'];
}
foreach ($categorias as $c) {
    if ((int)$c['idcatalogo'] === $idActivo) { $catActiva = $c; break; }
}
if (!$catActiva && !empty($categorias)) {
    $catActiva = $categorias[0];
    $idActivo  = (int)$catActiva['idcatalogo'];
}

// Cargar productos de la categoría activa
if ($catActiva && $db_cat) {
    try {
        $stmt = $db_cat->prepare("SELECT * FROM producto WHERE idcatalogo = :id AND disponible = 1");
        $stmt->execute([':id' => $idActivo]);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $productos = [];
    }
}

$nombreCat    = strtolower($catActiva['nombre'] ?? '');
$esYogurt     = str_contains($nombreCat, 'yogur');
$esEnsalada   = str_contains($nombreCat, 'ensalada');
$esMalt       = str_contains($nombreCat, 'malteada');
$esCanasta    = str_contains($nombreCat, 'canasta');
$esWaffle     = str_contains($nombreCat, 'waffle');
$esPersonalizable = $esYogurt || $esEnsalada || $esMalt || $esCanasta || $esWaffle;
$iconoCatSvg  = $_getIconSvg($catActiva['nombre'] ?? '');
?>
<style>
.cat-page-title { font-size: 1.55rem; font-weight: 900; color: var(--heading-color); margin-bottom: .2rem; }
.cat-page-sub   { font-size: .87rem; color: var(--muted-color); margin-bottom: 1.3rem; }

.cat-tabs-wrap {
    display: flex; align-items: center; gap: .45rem;
    overflow-x: auto; padding-bottom: .2rem; margin-bottom: 1.4rem;
    scrollbar-width: none;
}
.cat-tabs-wrap::-webkit-scrollbar { display: none; }
.cat-tab {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .48rem 1.05rem; border-radius: 999px; white-space: nowrap;
    font-size: .84rem; font-weight: 700; cursor: pointer;
    border: 1.5px solid var(--cat-tab-bd);
    background: var(--cat-tab-bg); color: var(--cat-tab-txt);
    text-decoration: none; transition: all .15s; flex-shrink: 0;
}
.cat-tab:hover  { background: var(--filter-btn-bg); color: var(--text-main); border-color: var(--cat-tab-bd); }
.cat-tab.active { background: #2563EB; color: #fff; border-color: #2563EB; }
.cat-tab-svg { width:15px; height:15px; flex-shrink:0; display:flex; align-items:center; }
.cat-tab-svg svg { width:15px; height:15px; }

.cat-banner {
    display: flex; align-items: center; gap: .7rem;
    padding: .75rem 1.05rem; border-radius: 11px; margin-bottom: 1.3rem;
    background: var(--cat-banner-bg); border: 1px solid var(--cat-banner-bd);
    transition: background .25s, border-color .25s;
}
.cat-banner-icon { width:22px; height:22px; flex-shrink:0; color:var(--cat-banner-name); }
.cat-banner-icon svg { width:22px; height:22px; }
.cat-banner-name { font-size: .88rem; font-weight: 800; color: var(--cat-banner-name); }
.cat-banner-desc { font-size: .76rem; color: var(--cat-banner-desc); }

.prod-grid-dark {
    display: grid; grid-template-columns: repeat(4,1fr); gap: 1rem;
}
@media(max-width:1100px){ .prod-grid-dark { grid-template-columns: repeat(3,1fr); } }
@media(max-width:750px) { .prod-grid-dark { grid-template-columns: repeat(2,1fr); } }
@media(max-width:480px) { .prod-grid-dark { grid-template-columns: 1fr; } }

.prod-card-dark {
    background: var(--prod-card-bg); border-radius: 13px;
    border: 1px solid var(--prod-card-bd);
    overflow: hidden; display: flex; flex-direction: column;
    transition: border-color .15s, transform .15s, background .25s;
}
.prod-card-dark:hover { border-color: rgba(37,99,235,.45); transform: translateY(-2px); }
.prod-img-dark {
    height: 125px; background: var(--prod-img-bg);
    display: flex; align-items: center; justify-content: center; overflow: hidden;
    transition: background .25s;
}
.prod-img-dark img { width:100%; height:100%; object-fit:cover; }
.prod-img-ph {
    width: 52px; height: 52px;
    display: flex; align-items: center; justify-content: center;
    color: var(--muted-color);
    opacity: .55;
}
.prod-img-ph svg { width: 52px; height: 52px; }
.prod-body-dark { padding: .8rem .9rem .95rem; flex:1; display:flex; flex-direction:column; }
.prod-badge-dark {
    display:inline-block; font-size:.67rem; font-weight:700;
    padding:.12rem .5rem; border-radius:20px; margin-bottom:.35rem;
    background:var(--badge-bg); color:var(--badge-txt);
    transition: background .25s, color .25s;
}
.prod-name-dark  { font-size:.91rem; font-weight:800; color:var(--heading-color); margin-bottom:.18rem; }
.prod-desc-dark  { font-size:.74rem; color:var(--muted-color); flex:1; margin-bottom:.6rem; line-height:1.4; }
.prod-price-dark { font-size:1.05rem; font-weight:900; color:#2563EB; margin-bottom:.65rem; }
.btn-pedir-dark {
    display:flex; align-items:center; justify-content:center; gap:.4rem;
    width:100%; padding:.58rem; border-radius:8px;
    background:var(--edit-banner-bg); color:var(--edit-banner-txt);
    border:1px solid var(--edit-banner-bd);
    font-family:'Nunito',sans-serif; font-size:.82rem; font-weight:800;
    cursor:pointer; text-decoration:none; transition:background .15s,color .15s,border-color .15s;
}
.btn-pedir-dark:hover { background:#2563EB; color:#fff; border-color:#2563EB; }
.btn-login-dark {
    display:block; width:100%; padding:.58rem; border-radius:8px; text-align:center;
    background:var(--btn-sec-bg); color:var(--btn-sec-txt);
    border:1px solid var(--card-border);
    font-family:'Nunito',sans-serif; font-size:.82rem; font-weight:700; text-decoration:none;
    transition: background .25s, color .25s, border-color .25s;
}
.btn-admin-dark {
    display:block; width:100%; padding:.58rem; border-radius:8px; text-align:center;
    background:var(--btn-sec-bg); color:var(--muted-color);
    border:1px solid var(--card-border);
    font-size:.76rem; font-weight:700;
    transition: background .25s, color .25s, border-color .25s;
}
</style>

<div class="cat-page-title">¿Qué se te antoja?</div>
<div class="cat-page-sub">Selecciona una categoría para ver nuestros productos</div>

<!-- Tabs de categorías -->
<div class="cat-tabs-wrap">
    <?php foreach ($categorias as $cat): ?>
        <a href="index.php?page=catalogo&idcatalogo=<?= (int)$cat['idcatalogo'] ?>"
           class="cat-tab <?= (int)$cat['idcatalogo'] === $idActivo ? 'active' : '' ?>">
            <span class="cat-tab-svg"><?= $_getIconSvg($cat['nombre']) ?></span>
            <?= htmlspecialchars($cat['nombre']) ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- Banner categoría activa -->
<?php if ($catActiva): ?>
<div class="cat-banner">
    <div class="cat-banner-icon"><?= $iconoCatSvg ?></div>
    <div>
        <div class="cat-banner-name"><?= htmlspecialchars($catActiva['nombre']) ?></div>
        <?php if (!empty($catActiva['descripcion'])): ?>
            <div class="cat-banner-desc"><?= htmlspecialchars($catActiva['descripcion']) ?></div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Alerta carrito -->
<?php if (isset($_GET['agregado']) && !empty($_SESSION['carrito_msg'])): ?>
<div style="background:var(--alert-ok-bg);border:1px solid var(--alert-ok-bd);border-radius:9px;padding:.7rem 1rem;margin-bottom:1rem;display:flex;align-items:center;justify-content:space-between;gap:1rem">
    <span style="font-size:.87rem;font-weight:700;color:var(--alert-ok-txt);display:flex;align-items:center;gap:.4rem;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; flex-shrink: 0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <?= htmlspecialchars($_SESSION['carrito_msg']) ?>
    </span>
    <a href="index.php?page=carrito" style="background:#059669;color:#fff;padding:.32rem .85rem;border-radius:7px;text-decoration:none;font-size:.8rem;font-weight:800;white-space:nowrap;display:flex;align-items:center;gap:.4rem;">
        Ver Carrito
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
    </a>
</div>
<?php unset($_SESSION['carrito_msg']); endif; ?>

<!-- Grid de productos -->
<?php if (!empty($productos)): ?>
<div class="prod-grid-dark">
    <?php foreach ($productos as $p):
        $iconoProdSvg = $_getProdIconSvg($p['nombre'], $catActiva['nombre'] ?? '');
    ?>
    <div class="prod-card-dark">
        <div class="prod-img-dark">
            <?php if (!empty($p['imagen'])): ?>
                <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
            <?php else: ?>
                <div class="prod-img-ph"><?= $iconoProdSvg ?></div>
            <?php endif; ?>
        </div>
        <div class="prod-body-dark">
            <div class="prod-badge-dark"><?= htmlspecialchars($catActiva['nombre']) ?></div>
            <div class="prod-name-dark"><?= htmlspecialchars($p['nombre']) ?></div>
            <div class="prod-desc-dark"><?= htmlspecialchars($p['descripcion'] ?? '') ?></div>
            <?php
            $precioVista = (float)$p['precio'];
            if (($esYogurt || $esEnsalada) && $precioVista < 1000 && $precioVista > 0) $precioVista *= 1000;
            ?>
            <div class="prod-price-dark">$<?= number_format($precioVista, 0, ',', '.') ?></div>

            <?php if (isLoggedIn()): ?>
                <?php if (getUserRole() === 'administrador'): ?>
                    <div class="btn-admin-dark">Vista previa — administrador</div>
                <?php elseif ($esPersonalizable): ?>
                    <a href="index.php?page=checkout_opciones&idproducto=<?= (int)$p['idproducto'] ?>" class="btn-pedir-dark">
                        <span style="width:14px;height:14px;display:flex;align-items:center;justify-content:center;color:currentColor;"><?= $iconoProdSvg ?></span> Personalizar y pedir
                    </a>
                <?php else: ?>
                    <form method="POST" action="index.php?page=carrito_agregar" style="margin:0">
                        <input type="hidden" name="idproducto" value="<?= (int)$p['idproducto'] ?>">
                        <input type="hidden" name="cantidad" value="1">
                        <button type="submit" class="btn-pedir-dark">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Agregar al carrito
                        </button>
                    </form>
                <?php endif; ?>
            <?php else: ?>
                <a href="index.php?page=login" class="btn-login-dark">Inicia sesión para pedir</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div style="color:var(--muted-color);padding:3rem 0;text-align:center;font-size:.9rem">No hay productos disponibles en esta categoría.</div>
<?php endif; ?>
