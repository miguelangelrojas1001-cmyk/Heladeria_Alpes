<style>
.dom-header { margin-bottom: 1.75rem; }
.dom-header h1 { display: flex; align-items: center; gap: .5rem; font-size: 1.6rem; font-weight: 900; color: var(--heading-color); margin-bottom: .3rem; }
.dom-header h1 svg { width: 28px; height: 28px; color: #2563EB; }
.dom-header p  { color: var(--muted-color); font-size: .93rem; }

/* Stats */
.stats-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 1.25rem; margin-bottom: 1.75rem; }
.stat-card { display: flex; flex-direction: column; background: var(--stat-card-bg); border-radius: 16px; padding: 1.25rem 1.5rem; box-shadow: var(--card-shadow); border: 1px solid var(--card-border); transition: background .25s, border-color .25s; }
.stat-icon { display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 10px; margin-bottom: .75rem; }
.stat-icon.blue { background: rgba(37,99,235,.1); color: #2563EB; }
.stat-icon.purple { background: rgba(139,92,246,.1); color: #8B5CF6; }
.stat-icon.green { background: rgba(16,185,129,.1); color: #10B981; }
.stat-icon svg { width: 20px; height: 20px; }
.stat-label { font-size: .78rem; font-weight: 700; color: var(--muted-color); text-transform: uppercase; letter-spacing: .05em; margin-bottom: .4rem; }
.stat-value { font-size: 1.9rem; font-weight: 900; color: var(--heading-color); }

/* Tabs */
.tabs { display: flex; gap: .5rem; margin-bottom: 1.5rem; border-bottom: 2px solid var(--tab-border); transition: border-color .25s; }
.tab-btn { display: inline-flex; align-items: center; gap: .4rem; padding: .6rem 1.25rem; border: none; background: none; cursor: pointer; font-family: 'Nunito',sans-serif; font-size: .9rem; font-weight: 700; color: var(--tab-txt); border-bottom: 3px solid transparent; margin-bottom: -2px; transition: color .15s, border-color .15s; }
.tab-btn svg { width: 16px; height: 16px; }
.tab-btn.active { color: var(--tab-active-txt); border-bottom-color: var(--tab-active-txt); }
.tab-btn:hover  { color: var(--tab-active-txt); }
.tab-panel { display: none; }
.tab-panel.active { display: block; }

/* Tarjeta de pedido */
.pedido-card { background: var(--pedido-card-bg); border-radius: 16px; border: 1.5px solid var(--pedido-card-bd); margin-bottom: 1rem; overflow: hidden; transition: box-shadow .2s, background .25s, border-color .25s; }
.pedido-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.12); }
.pedido-card.urgente { border-color: #FCA5A5; }

.pedido-head { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; cursor: pointer; user-select: none; }
.pedido-head-left { display: flex; align-items: center; gap: 1rem; }
.pedido-num   { font-size: 1rem; font-weight: 900; color: var(--pedido-num); }
.pedido-fecha { font-size: .8rem; color: var(--pedido-fecha); }
.pedido-total { font-size: 1rem; font-weight: 900; color: #2563EB; }
.chevron { display: inline-flex; align-items: center; justify-content: center; width: 18px; height: 18px; color: var(--muted-color); transition: transform .2s; }
.chevron svg { width: 14px; height: 14px; }
.chevron.open { transform: rotate(180deg); }

.badge { display: inline-block; padding: .25rem .8rem; border-radius: 20px; font-size: .75rem; font-weight: 800; }
.badge-pendiente  { background: #FEF3C7; color: #92400E; }
.badge-proceso    { background: #DBEAFE; color: #1E40AF; }
.badge-completado { background: #D1FAE5; color: #065F46; }
.badge-cancelado  { background: #FEE2E2; color: #991B1B; }

/* Detalle expandible */
.pedido-body { display: none; border-top: 1.5px solid var(--pedido-head-bd); }
.pedido-body.open { display: block; }

.pedido-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; padding: 1.25rem; }
@media(max-width:600px){ .pedido-info-grid { grid-template-columns: 1fr; } }

.info-block { background: var(--info-block-bg); border-radius: 12px; padding: 1rem; transition: background .25s; }
.info-block-title { display: flex; align-items: center; gap: .3rem; font-size: .72rem; font-weight: 800; color: var(--muted-color); text-transform: uppercase; letter-spacing: .06em; margin-bottom: .65rem; }
.info-block-title svg { width: 14px; height: 14px; color: #2563EB; }
.info-row { display: flex; justify-content: space-between; font-size: .85rem; padding: .3rem 0; border-bottom: 1px solid var(--table-row-bd); }
.info-row:last-child { border-bottom: none; }
.info-row .lbl { color: var(--muted-color); }
.info-row .val { font-weight: 700; color: var(--heading-color); text-align: right; max-width: 60%; }

.productos-list { padding: 0 1.25rem 1rem; }
.prod-item { display: flex; justify-content: space-between; align-items: flex-start; padding: .5rem 0; border-bottom: 1px solid var(--table-row-bd); font-size: .88rem; }
.prod-item:last-child { border-bottom: none; }
.prod-item .pnombre { font-weight: 700; color: var(--heading-color); }
.prod-item .psabores { font-size: .75rem; color: var(--muted-color); margin-top: .1rem; }
.prod-item .pprecio { font-weight: 800; color: #2563EB; white-space: nowrap; }

/* Botones de acción */
.acciones { display: flex; gap: .75rem; padding: 1rem 1.25rem; border-top: 1px solid var(--pedido-head-bd); background: var(--info-block-bg); transition: background .25s; }
.btn-accion { flex: 1; padding: .7rem; border: none; border-radius: 10px; font-family: 'Nunito',sans-serif; font-size: .9rem; font-weight: 800; cursor: pointer; transition: background .2s; }
.btn-camino    { background: #DBEAFE; color: #1E40AF; }
.btn-camino:hover { background: #BFDBFE; }
.btn-entregado { background: #D1FAE5; color: #065F46; }
.btn-entregado:hover { background: #A7F3D0; }

/* Mapa / dirección destacada */
.dir-box { background: var(--dir-box-bg); border: 1.5px solid var(--dir-box-bd); border-radius: 12px; padding: .85rem 1rem; margin: 0 1.25rem 1rem; display: flex; align-items: center; gap: .75rem; transition: background .25s, border-color .25s; }
.dir-box .icon { display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.dir-box .dir-text { font-size: .88rem; font-weight: 700; color: var(--dir-text); }
.dir-box .dir-sub { display: inline-flex; align-items: center; gap: .25rem; font-size: .78rem; color: var(--dir-sub); margin-top: .15rem; }

/* Empty state */
.empty-state { text-align: center; padding: 3rem 1rem; color: var(--muted-color); }
.empty-state .icon { display: flex; align-items: center; justify-content: center; width: 64px; height: 64px; margin: 0 auto 1rem; color: var(--muted-color); }
.empty-state .icon svg { width: 64px; height: 64px; stroke-width: 1.5; }
.empty-state h3 { font-size: 1.1rem; font-weight: 800; color: var(--empty-h3); margin-bottom: .5rem; }
</style>

<div class="dom-header">
    <h1>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/><path d="M3 17h12c1.7 0 3-1.3 3-3V8c0-1.7-1.3-3-3-3H9L5 9H1v4h2v4zm15-7h4v4h-4v-4z"/></svg>
        Panel Domiciliario
    </h1>
    <p>Gestiona tus entregas del día</p>
</div>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
        </div>
        <div class="stat-label">Pendientes</div>
        <div class="stat-value"><?= count($pedidosAsignados) ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
        <div class="stat-label">Entregados hoy</div>
        <div class="stat-value"><?= $totalHoy ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        </div>
        <div class="stat-label">Total entregas</div>
        <div class="stat-value"><?= $totalEntregas ?></div>
    </div>
</div>

<!-- Tabs -->
<div class="tabs">
    <button class="tab-btn active" onclick="switchTab('asignados',this)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/><path d="M3 17h12c1.7 0 3-1.3 3-3V8c0-1.7-1.3-3-3-3H9L5 9H1v4h2v4zm15-7h4v4h-4v-4z"/></svg>
        Pedidos asignados <span style="background:#EF4444;color:#fff;border-radius:20px;padding:.1rem .5rem;font-size:.72rem;margin-left:.3rem"><?= count($pedidosAsignados) ?></span>
    </button>
    <button class="tab-btn"       onclick="switchTab('historial',this)">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        Historial de entregas
    </button>
</div>

<!-- TAB: Asignados -->
<div class="tab-panel active" id="tab-asignados">
<?php if (empty($pedidosAsignados)): ?>
    <div class="empty-state">
        <div class="icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/><path d="M3 17h12c1.7 0 3-1.3 3-3V8c0-1.7-1.3-3-3-3H9L5 9H1v4h2v4zm15-7h4v4h-4v-4z"/></svg>
        </div>
        <h3>Sin pedidos asignados</h3>
        <p>Cuando el administrador te asigne un pedido aparecerá aquí.</p>
    </div>
<?php else: ?>
    <?php foreach ($pedidosAsignados as $p):
        $est = strtolower($p['estado'] ?? 'pendiente');
        $badgeClass = match($est) { 'en proceso' => 'badge-proceso', default => 'badge-pendiente' };
        $estadoLabel = match($est) {
            'en proceso' => '<span style="display:inline-flex;align-items:center;gap:.3rem;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>En camino</span>',
            default => '<span style="display:inline-flex;align-items:center;gap:.3rem;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Pendiente</span>'
        };
        $uid = 'dom_' . $p['idpedido'];
        $detalles = $detallesPorPedido[$p['idpedido']] ?? [];
    ?>
    <div class="pedido-card <?= $est === 'pendiente' ? 'urgente' : '' ?>">
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

            <!-- Dirección destacada -->
            <div class="dir-box">
                <div class="icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;color:#EF4444;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <div>
                    <div class="dir-text"><?= htmlspecialchars($p['direccion_completa'] ?? 'Sin dirección registrada') ?></div>
                    <?php if (!empty($p['telefono_contacto'])): ?>
                    <div class="dir-sub">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;color:var(--muted-color);vertical-align:middle;margin-right:.2rem;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <?= htmlspecialchars($p['telefono_contacto']) ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Info cliente + pedido -->
            <div class="pedido-info-grid">
                <div class="info-block">
                    <div class="info-block-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Cliente
                    </div>
                    <div class="info-row"><span class="lbl">Nombre</span><span class="val"><?= htmlspecialchars($p['cliente'] ?? '-') ?></span></div>
                    <?php if (!empty($p['telefono_contacto'])): ?>
                    <div class="info-row"><span class="lbl">Teléfono</span><span class="val"><?= htmlspecialchars($p['telefono_contacto']) ?></span></div>
                    <?php endif; ?>
                    <?php if (!empty($p['obs_envio'])): ?>
                    <div class="info-row"><span class="lbl">Observaciones</span><span class="val"><?= htmlspecialchars($p['obs_envio']) ?></span></div>
                    <?php endif; ?>
                </div>
                <div class="info-block">
                    <div class="info-block-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                        Pedido
                    </div>
                    <div class="info-row"><span class="lbl"># Pedido</span><span class="val">#<?= $p['idpedido'] ?></span></div>
                    <div class="info-row"><span class="lbl">Total</span><span class="val" style="color:#2563EB">$<?= number_format($p['total'], 0, ',', '.') ?></span></div>
                    <div class="info-row"><span class="lbl">Estado</span><span class="val"><?= $estadoLabel ?></span></div>
                </div>
            </div>

            <!-- Productos -->
            <?php if (!empty($detalles)): ?>
            <div class="productos-list">
                <div style="font-size:.72rem;font-weight:800;color:var(--muted-color);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem">Productos del pedido</div>
                <?php foreach ($detalles as $d): ?>
                <div class="prod-item">
                    <div>
                        <div class="pnombre"><?= htmlspecialchars($d['nombre_producto'] ?? 'Producto') ?> ×<?= $d['cantidad'] ?></div>
                        <?php if (!empty($d['sabores'])): ?>
                            <div class="psabores">Toppings: <?= htmlspecialchars($d['sabores']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($d['tamano'])): ?>
                            <div class="psabores">Tamaño: <?= htmlspecialchars($d['tamano']) ?></div>
                        <?php endif; ?>
                        <?php if (!empty($d['observaciones'])): ?>
                            <div class="psabores" style="color:#F59E0B">Obs: <?= htmlspecialchars($d['observaciones']) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="pprecio">$<?= number_format($d['total'], 0, ',', '.') ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Botones de acción -->
            <div class="acciones">
                <?php if ($est === 'pendiente'): ?>
                <form method="POST" action="index.php?page=domiciliario_pedidos" style="flex:1">
                    <input type="hidden" name="idpedido" value="<?= $p['idpedido'] ?>">
                    <button type="submit" name="marcar_en_camino" class="btn-accion btn-camino" style="width:100%; display:inline-flex; align-items:center; justify-content:center; gap:.4rem;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/><path d="M3 17h12c1.7 0 3-1.3 3-3V8c0-1.7-1.3-3-3-3H9L5 9H1v4h2v4zm15-7h4v4h-4v-4z"/></svg>
                        Marcar en camino
                    </button>
                </form>
                <?php endif; ?>
                <form method="POST" action="index.php?page=domiciliario_pedidos" style="flex:1">
                    <input type="hidden" name="idpedido" value="<?= $p['idpedido'] ?>">
                    <button type="submit" name="marcar_entregado" class="btn-accion btn-entregado" style="width:100%; display:inline-flex; align-items:center; justify-content:center; gap:.4rem;"
                            onclick="return confirm('¿Confirmar entrega del pedido #<?= $p['idpedido'] ?>?')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Confirmar entrega
                    </button>
                </form>
            </div>

        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>

<!-- TAB: Historial -->
<div class="tab-panel" id="tab-historial">
<?php if (empty($pedidosHistorial)): ?>
    <div class="empty-state">
        <div class="icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        </div>
        <h3>Sin historial aún</h3>
        <p>Aquí aparecerán tus entregas completadas.</p>
    </div>
<?php else: ?>
    <?php foreach ($pedidosHistorial as $p):
        $est = strtolower($p['estado'] ?? 'completado');
        $badgeClass = $est === 'completado' ? 'badge-completado' : 'badge-cancelado';
        $estadoLabel = $est === 'completado'
            ? '<span style="display:inline-flex;align-items:center;gap:.3rem;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>Entregado</span>'
            : '<span style="display:inline-flex;align-items:center;gap:.3rem;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:12px;height:12px;"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>Cancelado</span>';
        $uid = 'hist_' . $p['idpedido'];
        $detalles = $detallesPorPedido[$p['idpedido']] ?? [];
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
            <div class="pedido-info-grid">
                <div class="info-block">
                    <div class="info-block-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Cliente
                    </div>
                    <div class="info-row"><span class="lbl">Nombre</span><span class="val"><?= htmlspecialchars($p['cliente'] ?? '-') ?></span></div>
                </div>
                <div class="info-block">
                    <div class="info-block-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        Dirección
                    </div>
                    <div class="info-row"><span class="lbl">Entregado en</span><span class="val"><?= htmlspecialchars($p['direccion_completa'] ?? '-') ?></span></div>
                    <div class="info-row"><span class="lbl">Total</span><span class="val" style="color:#2563EB">$<?= number_format($p['total'], 0, ',', '.') ?></span></div>
                </div>
            </div>
            <?php if (!empty($detalles)): ?>
            <div class="productos-list">
                <div style="font-size:.72rem;font-weight:800;color:var(--muted-color);text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem">Productos</div>
                <?php foreach ($detalles as $d): ?>
                <div class="prod-item">
                    <div>
                        <div class="pnombre"><?= htmlspecialchars($d['nombre_producto'] ?? 'Producto') ?> ×<?= $d['cantidad'] ?></div>
                        <?php if (!empty($d['sabores'])): ?><div class="psabores"><?= htmlspecialchars($d['sabores']) ?></div><?php endif; ?>
                    </div>
                    <div class="pprecio">$<?= number_format($d['total'], 0, ',', '.') ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>

<script>
function switchTab(tab, btn) {
    document.querySelectorAll('.tab-panel').forEach(function(p){ p.classList.remove('active'); });
    document.querySelectorAll('.tab-btn').forEach(function(b){ b.classList.remove('active'); });
    document.getElementById('tab-' + tab).classList.add('active');
    btn.classList.add('active');
}
function togglePedido(uid) {
    var body = document.getElementById('body_' + uid);
    var chev = document.getElementById('chev_' + uid);
    var open = body.classList.toggle('open');
    chev.classList.toggle('open', open);
}
// Auto-expandir el primer pedido asignado
window.addEventListener('DOMContentLoaded', function() {
    var first = document.querySelector('#tab-asignados .pedido-body');
    var firstChev = document.querySelector('#tab-asignados .chevron');
    if (first) { first.classList.add('open'); if(firstChev) firstChev.classList.add('open'); }
});
</script>
