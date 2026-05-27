<style>
.prod-header { margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; }
.back-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .5rem 1rem; border-radius: 10px; background: var(--btn-sec-bg);
    color: var(--btn-sec-txt); text-decoration: none; font-size: .88rem; font-weight: 700;
    transition: background .15s;
}
.back-btn:hover { background: var(--btn-sec-hover); }
.prod-header h1 { font-size: 1.5rem; font-weight: 900; color: var(--heading-color); margin: 0; }
.prod-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 1.25rem; }
@media(max-width:900px){ .prod-grid { grid-template-columns: repeat(2,1fr); } }
@media(max-width:500px){ .prod-grid { grid-template-columns: 1fr; } }
.prod-card {
    background: var(--prod-card-bg); border-radius: 18px; border: 1.5px solid var(--prod-card-bd);
    overflow: hidden; transition: box-shadow .2s, transform .15s, background .25s, border-color .25s;
    display: flex; flex-direction: column;
}
.prod-card:hover { box-shadow: 0 8px 32px rgba(37,99,235,.11); transform: translateY(-2px); }
.prod-img { height: 140px; background: var(--prod-img-bg); display: flex; align-items: center; justify-content: center; overflow: hidden; transition: background .25s; }
.prod-img img { width: 100%; height: 100%; object-fit: cover; }
.prod-img-placeholder { width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg,#EFF6FF,#DBEAFE); display: flex; align-items: center; justify-content: center; }
.prod-img-placeholder svg { width: 30px; height: 30px; }
.prod-body { padding: .9rem 1rem 1.1rem; flex: 1; display: flex; flex-direction: column; }
.prod-name { font-size: .95rem; font-weight: 800; color: var(--heading-color); }
.prod-desc { font-size: .78rem; color: var(--muted-color); margin: .25rem 0 .65rem; flex: 1; }
.prod-price { font-size: 1.1rem; font-weight: 900; color: #2563EB; margin-bottom: .75rem; }
.btn-add {
    display: block; width: 100%; padding: .65rem;
    background: #2563EB; color: #fff; border: none; border-radius: 10px;
    font-family: 'Nunito', sans-serif; font-size: .88rem; font-weight: 800;
    cursor: pointer; text-align: center; text-decoration: none;
    transition: background .2s;
}
.btn-add:hover { background: #1D4ED8; }
.btn-add-yogurt {
    display: block; width: 100%; padding: .65rem;
    background: #0D9488; color: #fff; border: none; border-radius: 10px;
    font-family: 'Nunito', sans-serif; font-size: .88rem; font-weight: 800;
    cursor: pointer; text-align: center; text-decoration: none;
    transition: background .2s;
}
.btn-add-yogurt:hover { background: #0F766E; }
.empty-card { background: var(--card-bg); border-radius: 18px; padding: 3rem; text-align: center; color: var(--muted-color); border: 1px solid var(--card-border); }
.yogurt-badge { display:inline-block; background:#CCFBF1; color:#0F766E; font-size:.7rem; font-weight:800; padding:.15rem .5rem; border-radius:20px; margin-bottom:.4rem; }
.admin-preview-box { background:var(--btn-sec-bg);border-radius:8px;padding:.5rem .75rem;font-size:.78rem;color:var(--muted-color);font-weight:700;text-align:center; }
</style>

<?php
// Detectar si es categoría de helado de yogurt o ensaladas
$esYogurt   = false;
$esEnsalada = false;
if (!empty($catalogo)) {
    $nombreCat  = strtolower($catalogo['nombre'] ?? '');
    $esYogurt   = str_contains($nombreCat, 'yogurt') || str_contains($nombreCat, 'yogur');
    $esEnsalada = str_contains($nombreCat, 'ensalada');
}
$esPersonalizable = $esYogurt || $esEnsalada || str_contains($nombreCat ?? '', 'malteada') || str_contains($nombreCat ?? '', 'canasta') || str_contains($nombreCat ?? '', 'waffle');
?>

<div class="prod-header">
    <a href="index.php?page=catalogo" class="back-btn">← Volver</a>
    <h1><?= htmlspecialchars($catalogo['nombre'] ?? 'Productos disponibles') ?></h1>
</div>

<?php if (isset($_GET['agregado']) && !empty($_SESSION['carrito_msg'])): ?>
<div style="background:var(--alert-ok-bg);border:1.5px solid var(--alert-ok-bd);border-radius:12px;padding:.85rem 1.25rem;margin-bottom:1.25rem;display:flex;align-items:center;justify-content:space-between;gap:1rem">
    <span style="font-size:.9rem;font-weight:700;color:var(--alert-ok-txt);display:flex;align-items:center;gap:.4rem;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; flex-shrink: 0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <?= htmlspecialchars($_SESSION['carrito_msg']) ?>
    </span>
    <a href="index.php?page=carrito" style="background:#065F46;color:#fff;padding:.4rem 1rem;border-radius:8px;text-decoration:none;font-size:.85rem;font-weight:800;white-space:nowrap;display:flex;align-items:center;gap:.4rem;">
        Ver carrito
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
    </a>
</div>
<?php unset($_SESSION['carrito_msg']); endif; ?>

<?php if ($esYogurt): ?>
<div style="background:#F0FDFA;border:1.5px solid #99F6E4;border-radius:14px;padding:.85rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:.75rem">
    <span style="display:flex;align-items:center;color:#0D9488;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px;"><path d="M12 2C8.686 2 6 4.686 6 8c0 2.21 1.13 4.16 2.84 5.29L10 22h4l1.16-8.71C16.87 12.16 18 10.21 18 8c0-3.314-2.686-6-6-6z"/></svg></span>
    <div>
        <div style="font-size:.85rem;font-weight:800;color:#0F766E">Helado de Yogurt bajo en grasa y en azúcar</div>
        <div style="font-size:.78rem;color:#14B8A6">Al seleccionar un producto podrás elegir tus toppings y acompañamientos</div>
    </div>
</div>
<?php elseif ($esEnsalada): ?>
<div style="background:#FFF7ED;border:1.5px solid #FED7AA;border-radius:14px;padding:.85rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:.75rem">
    <span style="display:flex;align-items:center;color:#EA580C;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px;"><path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2z"/><path d="M12 2c0 5.523-4.477 10-10 10"/><path d="M12 2c0 5.523 4.477 10 10 10"/></svg></span>
    <div>
        <div style="font-size:.85rem;font-weight:800;color:#C2410C">Ensaladas de Frutas frescas</div>
        <div style="font-size:.78rem;color:#F97316">Al seleccionar una ensalada podrás elegir tus sabores de helado</div>
    </div>
</div>
<?php elseif (str_contains($nombreCat ?? '', 'waffle')): ?>
<div style="background:#FFFBEB;border:1.5px solid #FDE68A;border-radius:14px;padding:.85rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:.75rem">
    <span style="display:flex;align-items:center;color:#D97706;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px;"><rect x="3" y="3" width="18" height="18" rx="3"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/></svg></span>
    <div>
        <div style="font-size:.85rem;font-weight:800;color:#92400E">Waffles artesanales belgas</div>
        <div style="font-size:.78rem;color:#B45309">Crujientes por fuera, suaves por dentro. Arma el tuyo o elige uno especial. Adición bola de helado: $4.000</div>
    </div>
</div>
<?php elseif (str_contains($nombreCat ?? '', 'malteada')): ?>
<div style="background:#F5F3FF;border:1.5px solid #DDD6FE;border-radius:14px;padding:.85rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:.75rem">
    <span style="display:flex;align-items:center;color:#7C3AED;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px;"><path d="M8 2h8l1 10H7L8 2z"/><path d="M7 12l1 8a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2l1-8"/><line x1="10" y1="7" x2="14" y2="7"/></svg></span>
    <div>
        <div style="font-size:.85rem;font-weight:800;color:#5B21B6">Malteadas artesanales</div>
        <div style="font-size:.78rem;color:#7C3AED">Elige tu sabor favorito entre más de 20 opciones</div>
    </div>
</div>
<?php elseif (str_contains($nombreCat ?? '', 'canasta')): ?>
<div style="background:#F0FDFA;border:1.5px solid #99F6E4;border-radius:14px;padding:.85rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:.75rem">
    <span style="display:flex;align-items:center;color:#0D9488;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px;"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></span>
    <div>
        <div style="font-size:.85rem;font-weight:800;color:#0F766E">Canastas de frutas</div>
        <div style="font-size:.78rem;color:#14B8A6">Armalas a tu gusto con los toppings que desees</div>
    </div>
</div>
<?php endif; ?>

<?php if (!empty($productos)): ?>
<div class="prod-grid">
    <?php foreach ($productos as $p): ?>
    <div class="prod-card">
        <div class="prod-img">
            <?php if (!empty($p['imagen'])): ?>
                <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
            <?php else: ?>
                <div class="prod-img-placeholder">
                    <svg viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="15" cy="11" r="6" fill="#BFDBFE"/>
                        <path d="M9 19 Q15 26 21 19" stroke="#93C5FD" stroke-width="2" fill="none" stroke-linecap="round"/>
                    </svg>
                </div>
            <?php endif; ?>
        </div>
        <div class="prod-body">
            <?php if ($esYogurt): ?>
                <div class="yogurt-badge" style="display:inline-flex;align-items:center;gap:.3rem;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 12px; height: 12px;"><path d="M12 2C8.686 2 6 4.686 6 8c0 2.21 1.13 4.16 2.84 5.29L10 22h4l1.16-8.71C16.87 12.16 18 10.21 18 8c0-3.314-2.686-6-6-6z"/></svg>
                    Helado de Yogurt
                </div>
            <?php elseif ($esEnsalada): ?>
                <div class="yogurt-badge" style="background:#FFF7ED;color:#C2410C;display:inline-flex;align-items:center;gap:.3rem;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 12px; height: 12px;"><path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2z"/><path d="M12 2c0 5.523-4.477 10-10 10"/><path d="M12 2c0 5.523 4.477 10 10 10"/></svg>
                    Ensaladas de Frutas
                </div>
            <?php endif; ?>
            <div class="prod-name"><?= htmlspecialchars($p['nombre']) ?></div>
            <div class="prod-desc"><?= htmlspecialchars($p['descripcion'] ?? '') ?></div>
            <?php
            // Sanidad: precios menores a 1000 en yogurt/ensalada indican que faltan los ceros en BD
            $precioVista = (float)$p['precio'];
            if (($esYogurt || $esEnsalada) && $precioVista < 1000 && $precioVista > 0) {
                $precioVista *= 1000;
            }
            ?>
            <div class="prod-price">$<?= number_format($precioVista, 0, ',', '.') ?></div>
            <?php if (isLoggedIn()): ?>
                <?php if (getUserRole() === 'administrador'): ?>
                    <div class="admin-preview-box">
                        Vista previa — modo administrador
                    </div>
                <?php elseif ($esPersonalizable): ?>
                    <?php
                    $esWaffle = str_contains($nombreCat ?? '', 'waffle');
                    $esMalt   = str_contains($nombreCat ?? '', 'malteada');
                    $esCan    = str_contains($nombreCat ?? '', 'canasta');
                    $icono    = match(true) {
                        $esEnsalada => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;display:inline-block;vertical-align:middle;margin-right:4px;"><path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2z"/><path d="M12 2c0 5.523-4.477 10-10 10"/><path d="M12 2c0 5.523 4.477 10 10 10"/></svg>',
                        $esWaffle => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;display:inline-block;vertical-align:middle;margin-right:4px;"><rect x="3" y="3" width="18" height="18" rx="3"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/></svg>',
                        $esMalt => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;display:inline-block;vertical-align:middle;margin-right:4px;"><path d="M8 2h8l1 10H7L8 2z"/><path d="M7 12l1 8a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2l1-8"/><line x1="10" y1="7" x2="14" y2="7"/></svg>',
                        $esCan => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;display:inline-block;vertical-align:middle;margin-right:4px;"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
                        default => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;display:inline-block;vertical-align:middle;margin-right:4px;"><path d="M12 2C8.686 2 6 4.686 6 8c0 2.21 1.13 4.16 2.84 5.29L10 22h4l1.16-8.71C16.87 12.16 18 10.21 18 8c0-3.314-2.686-6-6-6z"/></svg>'
                    };
                    ?>
                    <a href="index.php?page=checkout_opciones&idproducto=<?= $p['idproducto'] ?>" class="btn-add-yogurt" style="display:flex;align-items:center;justify-content:center;gap:.3rem;">
                        <?= $icono ?> Personalizar y pedir
                    </a>
                <?php else: ?>
                    <form method="POST" action="index.php?page=carrito_agregar" style="margin:0">
                        <input type="hidden" name="idproducto" value="<?= $p['idproducto'] ?>">
                        <input type="hidden" name="cantidad" value="1">
                        <button type="submit" class="btn-add" style="display:flex;align-items:center;justify-content:center;gap:.4rem;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Agregar al carrito
                        </button>
                    </form>
                <?php endif; ?>
            <?php else: ?>
                <a href="index.php?page=login" class="btn-add" style="background:#64748B">Inicia sesión para pedir</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="empty-card">No hay productos disponibles en esta categoría.</div>
<?php endif; ?>
