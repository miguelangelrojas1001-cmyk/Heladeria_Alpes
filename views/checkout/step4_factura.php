<?php
$modo      = $_SESSION['checkout_modo']    ?? 'individual';
$orden     = $_SESSION['checkout_orden']   ?? [];
$entrega   = $_SESSION['checkout_entrega'] ?? [];
$idfactura = $_SESSION['ultima_factura']   ?? null;
$idpedido  = $_SESSION['ultimo_pedido']    ?? null;
$domicilio = 2000;

if ($modo === 'carrito') {
    $items             = $orden['items'] ?? [];
    $subtotalProductos = ($orden['total'] ?? 0) - $domicilio;
    $total             = $orden['total'] ?? 0;
} else {
    $items             = [];
    $subtotalProductos = ($orden['precio_unitario'] ?? 0) * ($orden['cantidad'] ?? 1);
    $domicilio         = (int)($orden['costo_domicilio'] ?? 2000);
    $total             = $subtotalProductos + $domicilio;
}

$fecha = date('d/m/Y');
$hora  = date('H:i');
ob_start();
?>
<style>
.fac-wrap { max-width:560px; margin:0 auto; }
.success-banner { text-align:center; margin-bottom:1.75rem; }
.success-banner .circle { width:68px;height:68px;border-radius:50%;background:#D1FAE5;display:inline-flex;align-items:center;justify-content:center;font-size:2rem;margin-bottom:.75rem; }
.success-banner h2 { font-size:1.2rem;font-weight:900;color:#065F46;margin-bottom:.25rem; }
.success-banner p  { font-size:.88rem;color:var(--muted-color); }
.fac-card { background:var(--fac-body-bg);border:1.5px solid var(--card-border);border-radius:16px;overflow:hidden;margin-bottom:1.25rem;box-shadow:var(--card-shadow);transition:background .25s,border-color .25s; }
.fac-head { background:#1E3A5F;color:#fff;padding:1.1rem 1.5rem;display:flex;justify-content:space-between;align-items:flex-start; }
.fac-head-logo { font-size:1.05rem;font-weight:900; }
.fac-head-sub  { font-size:.75rem;color:rgba(255,255,255,.55);margin-top:.15rem; }
.fac-head-right { text-align:right;font-size:.78rem;color:rgba(255,255,255,.6); }
.fac-head-right strong { display:block;color:#fff;font-size:.88rem; }
.fac-body { padding:0 1.5rem; }
.fac-section { font-size:.68rem;font-weight:800;color:var(--muted-color);text-transform:uppercase;letter-spacing:.08em;padding:1rem 0 .35rem;border-top:1px solid var(--fac-row-bd);margin-top:.25rem; }
.fac-section:first-child { border-top:none;padding-top:.85rem; }
.fac-row { display:flex;justify-content:space-between;align-items:baseline;padding:.45rem 0;font-size:.88rem;color:var(--body-color);border-bottom:1px solid var(--fac-row-bd); }
.fac-row:last-child { border-bottom:none; }
.fac-row .label { color:var(--muted-color); }
.fac-row .value { font-weight:700;text-align:right;max-width:60%;color:var(--heading-color); }
.fac-row.product-row .value { color:#2563EB;font-weight:800; }
.fac-subtotal { display:flex;justify-content:space-between;padding:.5rem 1.5rem;background:var(--fac-sub-bg);font-size:.88rem;color:var(--muted-color);border-top:1px solid var(--card-border);transition:background .25s; }
.fac-domicilio { display:flex;justify-content:space-between;padding:.5rem 1.5rem;background:var(--fac-sub-bg);font-size:.88rem;color:var(--muted-color);transition:background .25s; }
.fac-total { display:flex;justify-content:space-between;align-items:center;padding:.9rem 1.5rem;background:#1E3A5F;font-size:1.1rem;font-weight:900;color:#fff; }
.fac-total span:last-child { color:#93C5FD;font-size:1.2rem; }
.fac-estado { text-align:center;padding:.65rem 1.5rem;background:var(--fac-estado-bg);font-size:.82rem;font-weight:700;color:var(--fac-estado-txt);transition:background .25s,color .25s; }
.btn-row { display:flex;gap:.75rem;margin-top:1rem; }
.btn-home { flex:1;padding:.85rem;background:#2563EB;color:#fff;border-radius:12px;border:none;font-family:'Nunito',sans-serif;font-size:.95rem;font-weight:800;cursor:pointer;text-align:center;text-decoration:none;display:block; }
.btn-home:hover { background:#1D4ED8; }
.btn-print { flex:1;padding:.85rem;background:var(--btn-sec-bg);color:var(--btn-sec-txt);border-radius:12px;border:none;font-family:'Nunito',sans-serif;font-size:.95rem;font-weight:700;cursor:pointer;text-align:center;display:block;transition:background .15s; }
.btn-print:hover { background:var(--btn-sec-hover); }
</style>

<div class="fac-wrap">
    <div class="success-banner">
        <div class="circle">
            <svg viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px;"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <h2>¡Pedido confirmado!</h2>
        <p>Tu helado está en preparación — llegaremos pronto <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px; display: inline-block; vertical-align: middle; margin-left: 2px;"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></p>
    </div>

    <div class="fac-card">
        <div class="fac-head">
            <div>
                <div class="fac-head-logo" style="display:flex;align-items:center;gap:.35rem;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 18px; height: 18px;"><path d="M12 2a5 5 0 0 0-5 5v3a5 5 0 0 0 10 0V7a5 5 0 0 0-5-5z"/><path d="M6 10l6 11 6-11"/></svg>
                    <span>Los Alpes — Heladería</span>
                </div>
                <div class="fac-head-sub">
                    Pedido #<?= $idpedido ?>
                    <?php if ($idfactura): ?> &nbsp;·&nbsp; Factura #<?= $idfactura ?><?php endif; ?>
                </div>
            </div>
            <div class="fac-head-right">
                <strong><?= $fecha ?></strong><?= $hora ?>
            </div>
        </div>
        <div class="fac-body">
            <div class="fac-section">Productos</div>
            <?php if ($modo === 'carrito' && !empty($items)): ?>
                <?php foreach ($items as $item): ?>
                <div class="fac-row product-row">
                    <span class="label"><?= htmlspecialchars($item['nombre']) ?> &times;<?= $item['cantidad'] ?></span>
                    <span class="value">$<?= number_format($item['precio'] * $item['cantidad'], 0, ',', '.') ?></span>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="fac-row product-row">
                    <span class="label"><?= htmlspecialchars($orden['nombre_producto'] ?? 'Producto') ?> &times;<?= $orden['cantidad'] ?? 1 ?></span>
                    <span class="value">$<?= number_format($subtotalProductos, 0, ',', '.') ?></span>
                </div>
                <?php if (!empty($orden['sabores'])): ?>
                <div class="fac-row">
                    <span class="label"><?= !empty($orden['es_yogurt']) ? 'Toppings' : 'Sabores' ?></span>
                    <span class="value" style="font-size:.8rem;font-weight:600;color:#64748B"><?= htmlspecialchars($orden['sabores']) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($orden['tamano'])): ?>
                <div class="fac-row">
                    <span class="label">Tamaño</span>
                    <span class="value" style="text-transform:capitalize"><?= htmlspecialchars($orden['tamano']) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($orden['es_yogurt']) && !empty($orden['costo_toppings'])): ?>
                <div class="fac-row">
                    <span class="label" style="font-size:.8rem">Base del producto</span>
                    <span class="value" style="font-size:.8rem">$<?= number_format($orden['precio_base'] ?? 0, 0, ',', '.') ?></span>
                </div>
                <div class="fac-row">
                    <span class="label" style="font-size:.8rem">Toppings adicionales</span>
                    <span class="value" style="font-size:.8rem">$<?= number_format($orden['costo_toppings'], 0, ',', '.') ?></span>
                </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="fac-section">Entrega</div>
            <div class="fac-row"><span class="label">Destinatario</span><span class="value"><?= htmlspecialchars($entrega['destinatario'] ?? '-') ?></span></div>
            <div class="fac-row"><span class="label">Dirección</span><span class="value"><?= htmlspecialchars(($entrega['direccion'] ?? '') . ', ' . ($entrega['barrio'] ?? '')) ?></span></div>
            <div class="fac-row"><span class="label">Ciudad</span><span class="value"><?= htmlspecialchars($entrega['ciudad'] ?? '-') ?></span></div>
            <?php if (!empty($entrega['telefono'])): ?>
            <div class="fac-row"><span class="label">Teléfono</span><span class="value"><?= htmlspecialchars($entrega['telefono']) ?></span></div>
            <?php endif; ?>

            <div class="fac-section">Pago</div>
            <div class="fac-row"><span class="label">Método</span><span class="value" style="text-transform:capitalize"><?= htmlspecialchars($orden['metodopago'] ?? '-') ?></span></div>
            <div class="fac-row"><span class="label">Estado</span><span class="value" style="color:#F59E0B">Pendiente de pago</span></div>
        </div>
        <div class="fac-subtotal"><span>Subtotal productos</span><span>$<?= number_format($subtotalProductos, 0, ',', '.') ?></span></div>
        <div class="fac-domicilio"><span>Domicilio</span><span style="color:#F59E0B;font-weight:700">$<?= number_format($domicilio, 0, ',', '.') ?></span></div>
        <div class="fac-total"><span>Total a pagar</span><span>$<?= number_format($total, 0, ',', '.') ?></span></div>
        <div class="fac-estado">⏳ Pedido en preparación — te notificaremos cuando esté en camino</div>
    </div>

    <div class="btn-row">
        <a href="index.php?page=catalogo" class="btn-home" style="display:inline-flex;align-items:center;justify-content:center;gap:.35rem;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Volver al catálogo
        </a>
        <button onclick="imprimirFactura()" class="btn-print" style="display:inline-flex;align-items:center;justify-content:center;gap:.35rem;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Imprimir factura
        </button>
    </div>
</div>

<!-- Datos para impresión (oculto en pantalla) -->
<div id="factura-data" style="display:none">
<div class="p-head">
    <div>
        <div class="p-head-logo">Los Alpes — Heladería</div>
        <div class="p-head-sub">Pedido #<?= $idpedido ?><?php if ($idfactura): ?> · Factura #<?= $idfactura ?><?php endif; ?></div>
    </div>
    <div class="p-head-right"><strong><?= $fecha ?></strong><?= $hora ?></div>
</div>
<div class="p-body">
    <div class="p-sec">Productos</div>
    <?php if ($modo === 'carrito' && !empty($items)): ?>
        <?php foreach ($items as $item): ?>
        <div class="p-row"><span class="lbl"><?= htmlspecialchars($item['nombre']) ?> x<?= $item['cantidad'] ?></span><span class="val blue">$<?= number_format($item['precio'] * $item['cantidad'], 0, ',', '.') ?></span></div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="p-row"><span class="lbl"><?= htmlspecialchars($orden['nombre_producto'] ?? 'Producto') ?> x<?= $orden['cantidad'] ?? 1 ?></span><span class="val blue">$<?= number_format($subtotalProductos, 0, ',', '.') ?></span></div>
        <?php if (!empty($orden['sabores'])): ?><div class="p-row"><span class="lbl"><?= !empty($orden['es_yogurt']) ? 'Toppings' : 'Sabores' ?></span><span class="val" style="font-size:7.5pt"><?= htmlspecialchars($orden['sabores']) ?></span></div><?php endif; ?>
        <?php if (!empty($orden['tamano'])): ?><div class="p-row"><span class="lbl">Tamaño</span><span class="val" style="text-transform:capitalize"><?= htmlspecialchars($orden['tamano']) ?></span></div><?php endif; ?>
        <?php if (!empty($orden['es_yogurt']) && !empty($orden['costo_toppings'])): ?>
        <div class="p-row"><span class="lbl">Base del producto</span><span class="val">$<?= number_format($orden['precio_base'] ?? 0, 0, ',', '.') ?></span></div>
        <div class="p-row"><span class="lbl">Toppings adicionales</span><span class="val">$<?= number_format($orden['costo_toppings'], 0, ',', '.') ?></span></div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="p-sec">Entrega</div>
    <div class="p-row"><span class="lbl">Destinatario</span><span class="val"><?= htmlspecialchars($entrega['destinatario'] ?? '-') ?></span></div>
    <div class="p-row"><span class="lbl">Dirección</span><span class="val"><?= htmlspecialchars(($entrega['direccion'] ?? '') . ', ' . ($entrega['barrio'] ?? '')) ?></span></div>
    <div class="p-row"><span class="lbl">Ciudad</span><span class="val"><?= htmlspecialchars($entrega['ciudad'] ?? '-') ?></span></div>
    <?php if (!empty($entrega['telefono'])): ?><div class="p-row"><span class="lbl">Teléfono</span><span class="val"><?= htmlspecialchars($entrega['telefono']) ?></span></div><?php endif; ?>
    <div class="p-sec">Pago</div>
    <div class="p-row"><span class="lbl">Método</span><span class="val" style="text-transform:capitalize"><?= htmlspecialchars($orden['metodopago'] ?? '-') ?></span></div>
    <div class="p-row"><span class="lbl">Estado</span><span class="val" style="color:#D97706">Pendiente de pago</span></div>
</div>
<div class="p-sub"><span>Subtotal productos</span><span>$<?= number_format($subtotalProductos, 0, ',', '.') ?></span></div>
<div class="p-dom"><span>Domicilio</span><span style="color:#D97706;font-weight:700">$<?= number_format($domicilio, 0, ',', '.') ?></span></div>
<div class="p-total"><span>Total a pagar</span><span>$<?= number_format($total, 0, ',', '.') ?></span></div>
<div class="p-footer">Gracias por tu compra · Los Alpes Heladería · <?= $fecha ?></div>
</div>

<script>
function imprimirFactura() {
    var html = document.getElementById('factura-data').innerHTML;
    var win = window.open('', '_blank', 'width=700,height=900');
    win.document.write('<!DOCTYPE html><html lang="es"><head>'
        + '<meta charset="UTF-8"><title>Factura - Los Alpes</title>'
        + '<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">'
        + '<style>'
        + '* { box-sizing:border-box; margin:0; padding:0; }'
        + 'body { font-family:Nunito,Arial,sans-serif; background:#fff; color:#0F172A; padding:24px; }'
        + '.p-head { background:#1E3A5F; color:#fff; padding:14px 20px; border-radius:10px 10px 0 0; display:flex; justify-content:space-between; align-items:flex-start; -webkit-print-color-adjust:exact; print-color-adjust:exact; }'
        + '.p-head-logo { font-size:14pt; font-weight:900; }'
        + '.p-head-sub { font-size:8pt; color:rgba(255,255,255,.6); margin-top:3px; }'
        + '.p-head-right { text-align:right; font-size:8pt; color:rgba(255,255,255,.6); }'
        + '.p-head-right strong { display:block; color:#fff; font-size:9pt; }'
        + '.p-body { border:1px solid #E2E8F0; border-top:none; padding:0 20px; }'
        + '.p-sec { font-size:7pt; font-weight:800; color:#94A3B8; text-transform:uppercase; letter-spacing:.08em; padding:10px 0 4px; border-top:1px solid #F1F5F9; margin-top:4px; }'
        + '.p-sec:first-child { border-top:none; padding-top:12px; }'
        + '.p-row { display:flex; justify-content:space-between; padding:5px 0; font-size:9pt; border-bottom:1px solid #F8FAFC; }'
        + '.p-row:last-child { border-bottom:none; }'
        + '.p-row .lbl { color:#64748B; }'
        + '.p-row .val { font-weight:700; text-align:right; max-width:60%; }'
        + '.p-row .val.blue { color:#1D4ED8; }'
        + '.p-sub { display:flex; justify-content:space-between; padding:5px 20px; font-size:9pt; color:#64748B; background:#F8FAFC; border-top:1px solid #F1F5F9; }'
        + '.p-dom { display:flex; justify-content:space-between; padding:5px 20px; font-size:9pt; color:#64748B; background:#F8FAFC; }'
        + '.p-total { display:flex; justify-content:space-between; padding:10px 20px; background:#1E3A5F; color:#fff; font-size:12pt; font-weight:900; border-radius:0 0 10px 10px; -webkit-print-color-adjust:exact; print-color-adjust:exact; }'
        + '.p-total span:last-child { color:#93C5FD; }'
        + '.p-footer { text-align:center; margin-top:16px; font-size:7.5pt; color:#94A3B8; }'
        + '@media print { body { padding:0; } @page { margin:1cm; } }'
        + '</style></head><body>' + html
        + '<scr' + 'ipt>window.onload=function(){window.print();}<\/scr' + 'ipt>'
        + '</body></html>');
    win.document.close();
}
</script>

<?php
$step_content = ob_get_clean();
$step       = 4;
$step_title = 'Factura generada';
include __DIR__ . '/step_layout.php';
