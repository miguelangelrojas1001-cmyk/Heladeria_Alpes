<style>
.cli-header { margin-bottom: 1.75rem; }
.cli-header h1 { display: flex; align-items: center; gap: .5rem; font-size: 1.6rem; font-weight: 900; color: var(--heading-color); margin-bottom: .3rem; }
.cli-header h1 svg { width: 28px; height: 28px; color: #2563EB; }
.cli-header p  { color: var(--muted-color); font-size: .93rem; }

/* Tabs */
.tabs { display: flex; gap: .5rem; margin-bottom: 1.5rem; border-bottom: 2px solid var(--tab-border); padding-bottom: 0; transition: border-color .25s; }
.tab-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .6rem 1.25rem; border: none; background: none; cursor: pointer;
    font-family: 'Nunito', sans-serif; font-size: .9rem; font-weight: 700;
    color: var(--tab-txt); border-bottom: 3px solid transparent; margin-bottom: -2px;
    transition: color .15s, border-color .15s;
}
.tab-btn svg { width: 16px; height: 16px; }
.tab-btn.active { color: var(--tab-active-txt); border-bottom-color: var(--tab-active-txt); }
.tab-btn:hover  { color: var(--tab-active-txt); }
.tab-panel { display: none; }
.tab-panel.active { display: block; }

/* Cards de pedido */
.pedido-card {
    background: var(--pedido-card-bg); border-radius: 16px; border: 1.5px solid var(--pedido-card-bd);
    margin-bottom: 1rem; overflow: hidden; transition: box-shadow .2s, background .25s, border-color .25s;
}
.pedido-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.12); }
.pedido-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.25rem; cursor: pointer; user-select: none;
}
.pedido-head-left { display: flex; align-items: center; gap: 1rem; }
.pedido-num  { font-size: 1rem; font-weight: 900; color: var(--pedido-num); }
.pedido-fecha { font-size: .8rem; color: var(--pedido-fecha); }
.pedido-total { font-size: 1rem; font-weight: 900; color: #2563EB; }
.badge { display: inline-block; padding: .25rem .8rem; border-radius: 20px; font-size: .75rem; font-weight: 800; }
.badge-pendiente  { background: #FEF3C7; color: #92400E; }
.badge-proceso    { background: #DBEAFE; color: #1E40AF; }
.badge-completado { background: #D1FAE5; color: #065F46; }
.badge-cancelado  { background: #FEE2E2; color: #991B1B; }
.chevron { display: inline-flex; align-items: center; justify-content: center; width: 18px; height: 18px; color: var(--muted-color); transition: transform .2s; }
.chevron svg { width: 14px; height: 14px; }
.chevron.open { transform: rotate(180deg); }

/* Detalle expandible */
.pedido-body { display: none; border-top: 1.5px solid var(--pedido-head-bd); padding: 1.25rem; }
.pedido-body.open { display: block; }

/* Factura dentro del detalle */
.factura-mini { background: var(--factura-mini-bg); border-radius: 12px; border: 1.5px solid var(--factura-mini-bd); overflow: hidden; margin-top: 1rem; transition: background .25s, border-color .25s; }
.factura-mini-head { background: #1E3A5F; color: #fff; padding: .75rem 1.25rem; display: flex; justify-content: space-between; align-items: center; }
.factura-mini-head-title { font-size: .9rem; font-weight: 800; }
.factura-mini-head-num   { font-size: .75rem; color: rgba(255,255,255,.6); }
.factura-mini-body { padding: 1rem 1.25rem; }
.frow { display: flex; justify-content: space-between; padding: .4rem 0; font-size: .85rem; color: var(--body-color); border-bottom: 1px solid var(--table-row-bd); }
.frow:last-child { border-bottom: none; }
.fsec { font-size: .7rem; font-weight: 800; color: var(--muted-color); text-transform: uppercase; letter-spacing: .06em; padding: .5rem 0 .15rem; }
.ftotal { display: flex; justify-content: space-between; padding: .75rem 1.25rem; background: #EFF6FF; font-size: 1rem; font-weight: 900; color: #1D4ED8; }

/* Vacío */
.empty-state { text-align: center; padding: 3rem 1rem; color: var(--muted-color); }
.empty-state .icon { display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; margin: 0 auto 1rem; color: var(--muted-color); }
.empty-state .icon svg { width: 64px; height: 64px; stroke-width: 1.5; }
.empty-state h3 { font-size: 1.1rem; font-weight: 800; color: var(--empty-h3); margin-bottom: .5rem; }

/* Botón imprimir */
.btn-print { display: inline-flex; align-items: center; gap: .4rem; padding: .45rem 1rem; background: var(--btn-sec-bg); color: var(--btn-sec-txt); border: none; border-radius: 8px; font-family: 'Nunito', sans-serif; font-size: .82rem; font-weight: 700; cursor: pointer; margin-top: .75rem; transition: background .15s; }
.btn-print:hover { background: var(--btn-sec-hover); }

/* Productos dentro del detalle */
.det-prod-row { display:flex; justify-content:space-between; align-items:center; padding:.45rem 0; border-bottom:1px solid var(--table-row-bd); font-size:.88rem; }
.det-prod-name { font-weight:700; color:var(--heading-color); }
.det-prod-extra { color:var(--muted-color); font-size:.78rem; }
.det-prod-price { font-weight:800; color:#2563EB; }
.det-sec-label { font-size:.75rem; font-weight:800; color:var(--muted-color); text-transform:uppercase; letter-spacing:.06em; margin-bottom:.5rem; }
</style>

<div class="cli-header">
    <h1>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
        Mis Pedidos
    </h1>
    <p>Consulta el estado y el historial de todos tus pedidos.</p>
</div>

<!-- Tabs -->
<div class="tabs">
    <button class="tab-btn active" onclick="switchTab('activos', this)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Pedidos activos
    </button>
    <button class="tab-btn"       onclick="switchTab('historial', this)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        Historial
    </button>
</div>

<!-- TAB: Activos -->
<div class="tab-panel active" id="tab-activos">
    <?php
    $activos = array_filter($pedidos, fn($p) => in_array(strtolower($p['estado'] ?? ''), ['pendiente','en proceso']));
    ?>
    <?php if (empty($activos)): ?>
        <div class="empty-state">
            <div class="icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/><path d="M3 17h12c1.7 0 3-1.3 3-3V8c0-1.7-1.3-3-3-3H9L5 9H1v4h2v4zm15-7h4v4h-4v-4z"/></svg>
            </div>
            <h3>No tienes pedidos activos</h3>
            <p>Cuando hagas un pedido aparecerá aquí con su estado en tiempo real.</p>
            <a href="index.php?page=catalogo" style="display:inline-block;margin-top:1rem;padding:.7rem 1.5rem;background:#2563EB;color:#fff;border-radius:10px;text-decoration:none;font-weight:800">Ver catálogo</a>
        </div>
    <?php else: ?>
        <?php foreach ($activos as $p): ?>
            <?= renderPedidoCard($p, $detallesPorPedido, $facturasPorPedido) ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- TAB: Historial -->
<div class="tab-panel" id="tab-historial">
    <?php
    $historial = array_filter($pedidos, fn($p) => in_array(strtolower($p['estado'] ?? ''), ['completado','cancelado']));
    ?>
    <?php if (empty($historial)): ?>
        <div class="empty-state">
            <div class="icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <h3>Sin historial aún</h3>
            <p>Aquí aparecerán tus pedidos completados o cancelados.</p>
        </div>
    <?php else: ?>
        <?php foreach ($historial as $p): ?>
            <?= renderPedidoCard($p, $detallesPorPedido, $facturasPorPedido) ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php
function renderPedidoCard($p, $detallesPorPedido, $facturasPorPedido): string
{
    $est = strtolower($p['estado'] ?? 'pendiente');
    $badgeClass = match($est) {
        'completado' => 'badge-completado',
        'cancelado'  => 'badge-cancelado',
        'en proceso' => 'badge-proceso',
        default      => 'badge-pendiente',
    };
    $estadoLabel = match($est) {
        'en proceso' => '<span style="display:inline-flex;align-items:center;gap:.3rem;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>En proceso</span>',
        'completado' => '<span style="display:inline-flex;align-items:center;gap:.3rem;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>Completado</span>',
        'cancelado'  => '<span style="display:inline-flex;align-items:center;gap:.3rem;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>Cancelado</span>',
        default      => '<span style="display:inline-flex;align-items:center;gap:.3rem;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Pendiente</span>',
    };

    $detalles = $detallesPorPedido[$p['idpedido']] ?? [];
    $factura  = $facturasPorPedido[$p['idpedido']] ?? null;
    $uid = 'ped_' . $p['idpedido'];

    ob_start();
    ?>
    <div class="pedido-card">
        <div class="pedido-head" onclick="togglePedido('<?= $uid ?>')">
            <div class="pedido-head-left">
                <div>
                    <div class="pedido-num">Pedido #<?= $p['idpedido'] ?></div>
                    <div class="pedido-fecha"><?= $p['fecha'] ? date('d/m/Y H:i', strtotime($p['fecha'])) : '-' ?></div>
                </div>
                <span class="badge <?= $badgeClass ?>"><?= $estadoLabel ?></span>
            </div>
            <div style="display:flex;align-items:center;gap:1rem">
                <div class="pedido-total">$<?= number_format($p['total'], 0, ',', '.') ?></div>
                <span class="chevron" id="chev_<?= $uid ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </span>
            </div>
        </div>

        <div class="pedido-body" id="body_<?= $uid ?>">

            <!-- Productos del pedido -->
            <?php if (!empty($detalles)): ?>
            <div style="margin-bottom:.75rem">
                <div class="det-sec-label">Productos</div>
                <?php foreach ($detalles as $d): ?>
                <div class="det-prod-row">
                    <div>
                        <span class="det-prod-name"><?= htmlspecialchars($d['nombre_producto'] ?? $d['idproducto']) ?></span>
                        <?php if (!empty($d['sabores'])): ?>
                            <span class="det-prod-extra"> · <?= htmlspecialchars($d['sabores']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($d['tamano'])): ?>
                            <span class="det-prod-extra"> · <?= htmlspecialchars($d['tamano']) ?></span>
                        <?php endif; ?>
                        <span class="det-prod-extra"> ×<?= $d['cantidad'] ?></span>
                    </div>
                    <span class="det-prod-price">$<?= number_format($d['total'], 0, ',', '.') ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Factura -->
            <?php if ($factura): ?>
            <div class="factura-mini" id="fac_<?= $uid ?>">
                <div class="factura-mini-head">
                    <div>
                        <div class="factura-mini-head-title" style="display:flex;align-items:center;gap:.4rem;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            Los Alpes — Heladería
                        </div>
                        <div class="factura-mini-head-num">Pedido #<?= $p['idpedido'] ?> · Factura #<?= $factura['idfactura'] ?></div>
                    </div>
                    <div style="font-size:.78rem;color:rgba(255,255,255,.6)"><?= $factura['fecha'] ? date('d/m/Y H:i', strtotime($factura['fecha'])) : '' ?></div>
                </div>
                <div class="factura-mini-body">
                    <div class="fsec">Productos</div>
                    <?php foreach ($detalles as $d): ?>
                    <div class="frow">
                        <span><?= htmlspecialchars($d['nombre_producto'] ?? 'Producto') ?> ×<?= $d['cantidad'] ?></span>
                        <span>$<?= number_format($d['total'], 0, ',', '.') ?></span>
                    </div>
                    <?php endforeach; ?>
                    <div class="fsec">Pago</div>
                    <div class="frow">
                        <span>Método</span>
                        <span style="text-transform:capitalize;font-weight:700"><?= htmlspecialchars($factura['metodopago'] ?? '-') ?></span>
                    </div>
                    <div class="frow">
                        <span>Estado</span>
                        <span style="color:#2563EB;font-weight:700">
                            <?= $est === 'completado' ? 'Pagado' : 'Pendiente de pago' ?>
                        </span>
                    </div>
                </div>
                <div class="ftotal">
                    <span>Total</span>
                    <span>$<?= number_format($factura['totalfactura'], 0, ',', '.') ?></span>
                </div>
            </div>
            <button class="btn-print" onclick="imprimirFactura('fac_<?= $uid ?>')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14px;height:14px;"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Imprimir factura
            </button>
            <?php endif; ?>

        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>

<script>
function switchTab(tab, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    btn.classList.add('active');
}

function togglePedido(uid) {
    const body = document.getElementById('body_' + uid);
    const chev = document.getElementById('chev_' + uid);
    const open = body.classList.toggle('open');
    chev.classList.toggle('open', open);
}

function imprimirFactura(facId) {
    const el = document.getElementById(facId);
    const win = window.open('', '_blank', 'width=600,height=700');
    win.document.write(`
        <html><head><title>Factura — Los Alpes</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&display=swap" rel="stylesheet">
        <style>
            body { font-family: 'Nunito', sans-serif; padding: 2rem; background: #fff; color: #0F172A; }
            .head { background: #1E3A5F; color: #fff; padding: 1rem 1.5rem; border-radius: 10px 10px 0 0; display: flex; justify-content: space-between; }
            .head-title { font-size: 1.1rem; font-weight: 900; }
            .head-num { font-size: .8rem; color: rgba(255,255,255,.6); margin-top: .2rem; }
            .body { padding: 1rem 1.5rem; border: 1px solid #E2E8F0; border-top: none; }
            .sec { font-size: .7rem; font-weight: 800; color: #94A3B8; text-transform: uppercase; letter-spacing: .06em; padding: .5rem 0 .15rem; }
            .row { display: flex; justify-content: space-between; padding: .4rem 0; font-size: .88rem; border-bottom: 1px solid #F1F5F9; }
            .total { display: flex; justify-content: space-between; padding: .75rem 1.5rem; background: #EFF6FF; font-size: 1rem; font-weight: 900; color: #1D4ED8; border-radius: 0 0 10px 10px; }
            @media print { body { padding: 0; } }
        </style></head><body>
        ${el.outerHTML.replace(/class="factura-mini"/,'style="font-family:Nunito,sans-serif"')}
        <script>window.onload=()=>window.print()<\/script>
        </body></html>
    `);
    win.document.close();
}
</script>
