<?php /* Carrito view */ ?>
<style>
    .carrito-header { margin-bottom: 1.75rem; }
    .carrito-header h1 { font-size: 1.6rem; font-weight: 900; color: var(--heading-color); margin-bottom: .3rem; }
    .carrito-header p { color: var(--muted-color); font-size: .93rem; }
    .carrito-grid { display: grid; grid-template-columns: 1fr 360px; gap: 1.5rem; align-items: start; }
    .card { background: var(--card-bg); border-radius: 16px; box-shadow: var(--card-shadow); padding: 1.5rem; border: 1px solid var(--card-border); transition: background .25s, border-color .25s; }
    .card-title { font-size: 1.05rem; font-weight: 800; color: var(--heading-color); margin-bottom: 1.25rem; }
    .item-row { display: flex; align-items: center; gap: 1rem; padding: 1rem 0; border-bottom: 1px solid var(--table-row-bd); }
    .item-row:last-child { border-bottom: none; }
    .item-icon { width: 56px; height: 56px; background: var(--item-icon-bg); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; flex-shrink: 0; transition: background .25s; }
    .item-info { flex: 1; }
    .item-name { font-weight: 800; color: var(--item-name); font-size: .95rem; }
    .item-qty { font-size: .82rem; color: var(--item-qty); }
    .item-price { font-weight: 900; color: #2563EB; font-size: 1rem; }
    .item-remove { background: none; border: none; cursor: pointer; color: #EF4444; font-size: .85rem; font-weight: 700; padding: .3rem .6rem; border-radius: 7px; text-decoration: none; transition: background .15s; }
    .item-remove:hover { background: #FEE2E2; }
    .resumen-row { display: flex; justify-content: space-between; padding: .6rem 0; font-size: .92rem; color: var(--body-color); }
    .resumen-total { display: flex; justify-content: space-between; padding: .85rem 0; border-top: 2px solid var(--card-border); margin-top: .5rem; font-size: 1.1rem; font-weight: 900; color: var(--heading-color); }
    .btn-checkout { display: block; width: 100%; padding: .95rem; background: #2563EB; color: #fff; border: none; border-radius: 12px; font-family: 'Nunito', sans-serif; font-size: 1rem; font-weight: 800; cursor: pointer; text-align: center; text-decoration: none; margin-top: 1rem; transition: background .2s; }
    .btn-checkout:hover { background: #1D4ED8; }
    .btn-vaciar { display: block; width: 100%; padding: .65rem; background: var(--btn-sec-bg); color: var(--btn-sec-txt); border: none; border-radius: 10px; font-family: 'Nunito', sans-serif; font-size: .88rem; font-weight: 700; cursor: pointer; margin-top: .65rem; text-align: center; text-decoration: none; transition: background .2s; }
    .btn-vaciar:hover { background: #FEE2E2; color: #EF4444; }
    .carrito-vacio { text-align: center; padding: 3rem 1rem; }
    .carrito-vacio .icon { font-size: 3.5rem; margin-bottom: 1rem; }
    .carrito-vacio h3 { font-size: 1.2rem; font-weight: 800; color: var(--carrito-vacio-h); margin-bottom: .5rem; }
    .carrito-vacio p { color: var(--carrito-vacio-p); margin-bottom: 1.5rem; }
    .btn-ir { display: inline-block; padding: .75rem 1.75rem; background: #2563EB; color: #fff; border-radius: 12px; text-decoration: none; font-weight: 800; font-size: .95rem; }
    .qty-btn { width:26px; height:26px; border-radius:6px; border:1.5px solid var(--qty-btn-bd); background:var(--qty-btn-bg); font-size:.9rem; font-weight:800; cursor:pointer; line-height:1; color:var(--heading-color); transition:background .15s, border-color .25s; }
    .qty-input { width:48px; text-align:center; padding:.2rem .3rem; font-size:.85rem; font-weight:800; border:1.5px solid var(--qty-input-bd); border-radius:6px; background:var(--qty-input-bg); color:var(--input-color); transition:background .25s, border-color .25s, color .25s; }
</style>

<div class="carrito-header">
    <h1 style="display:flex;align-items:center;gap:.6rem;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 28px; height: 28px; color: var(--blue);"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        Mi Carrito
    </h1>
    <p>Revisa y confirma tu pedido antes de proceder.</p>
</div>

<?php
$carrito = $_SESSION['carrito'] ?? [];
$total = array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], $carrito));
?>

<?php if (!empty($carrito)): ?>
<div class="carrito-grid">
    <div class="card">
        <div class="card-title">Productos seleccionados</div>
        <?php foreach ($carrito as $claveCarrito => $item): ?>
        <div class="item-row">
            <div class="item-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 28px; height: 28px; color: var(--blue);"><path d="M12 12A5 5 0 1 0 12 2a5 5 0 0 0 0 10z"/><path d="M12 12 L7 12 L12 22 L17 12 Z"/></svg>
            </div>
            <div class="item-info">
                <div class="item-name"><?= htmlspecialchars($item['nombre']) ?></div>
                <?php if (!empty($item['sabores'])): ?>
                    <div style="font-size:.75rem;color:var(--muted-color);margin-top:.15rem">
                        <?= !empty($item['es_yogurt']) ? 'Toppings: ' : 'Sabores: ' ?>
                        <?= htmlspecialchars($item['sabores']) ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($item['tamano'])): ?>
                    <div style="font-size:.75rem;color:var(--muted-color)">Tamaño: <?= htmlspecialchars($item['tamano']) ?></div>
                <?php endif; ?>
                <form method="POST" action="index.php?page=carrito_actualizar" style="margin:0;display:flex;align-items:center;gap:.5rem;margin-top:.35rem">
                    <input type="hidden" name="idproducto" value="<?= htmlspecialchars($claveCarrito) ?>">
                    <button type="button" onclick="cambiarCantidad(this,-1)" class="qty-btn">−</button>
                    <input type="number" name="cantidad" value="<?= $item['cantidad'] ?>" min="1" max="20"
                           class="qty-input"
                           onchange="this.form.submit()">
                    <button type="button" onclick="cambiarCantidad(this,1)" class="qty-btn">+</button>
                </form>
            </div>
            <div>
                <div class="item-price">$<?= number_format($item['precio'] * $item['cantidad'], 0, ',', '.') ?></div>
                <?php if (!empty($item['costo_toppings'])): ?>
                    <div style="font-size:.72rem;color:var(--muted-color);text-align:right">Base: $<?= number_format($item['precio_base'] ?? $item['precio'], 0, ',', '.') ?></div>
                <?php endif; ?>
            </div>
            <a href="index.php?page=carrito_eliminar&id=<?= urlencode($claveCarrito) ?>" class="item-remove">✕</a>
        </div>
        <?php endforeach; ?>
    </div>

    <div>
        <div class="card">
            <div class="card-title">Resumen del pedido</div>
            <?php foreach ($carrito as $item): ?>
            <div class="resumen-row">
                <span><?= htmlspecialchars($item['nombre']) ?> ×<?= $item['cantidad'] ?></span>
                <span>$<?= number_format($item['precio'] * $item['cantidad'], 0, ',', '.') ?></span>
            </div>
            <?php endforeach; ?>
            <div class="resumen-total">
                <span>Total</span>
                <span>$<?= number_format($total, 0, ',', '.') ?></span>
            </div>
            <a href="index.php?page=checkout_entrega&desde=carrito" class="btn-checkout">Proceder al pago →</a>
            <a href="index.php?page=carrito_vaciar" onclick="return confirm('¿Vaciar carrito?')" class="btn-vaciar" style="display:flex;align-items:center;justify-content:center;gap:.4rem;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                Vaciar carrito
            </a>
        </div>
    </div>
</div>
<?php else: ?>
<div class="card">
    <div class="carrito-vacio">
        <div class="icon" style="display:flex;align-items:center;justify-content:center;color:var(--muted-color);opacity:.5;margin-bottom:1rem;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 56px; height: 56px;"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        </div>
        <h3>Tu carrito está vacío</h3>
        <p>Agrega productos desde el catálogo para comenzar tu pedido.</p>
        <a href="index.php?page=catalogo" class="btn-ir">Ver catálogo</a>
    </div>
</div>
<?php endif; ?>

<script>
function cambiarCantidad(btn, delta) {
    const form = btn.closest('form');
    const input = form.querySelector('input[name="cantidad"]');
    let v = parseInt(input.value) + delta;
    if (v < 1) v = 1;
    if (v > 20) v = 20;
    input.value = v;
    form.submit();
}
</script>
