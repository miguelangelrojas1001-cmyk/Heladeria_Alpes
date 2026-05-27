<style>
    .admin-header { margin-bottom: 1.75rem; }
    .admin-header h1 { font-size: 1.6rem; font-weight: 900; color: var(--heading-color); margin-bottom: .3rem; }
    .admin-header p { color: var(--muted-color); font-size: .93rem; }
    .card { background: var(--card-bg); border-radius: 16px; box-shadow: var(--card-shadow); padding: 1.5rem; margin-bottom: 1.5rem; border: 1px solid var(--card-border); transition: background .25s, border-color .25s; }
    .card-title { font-size: 1.05rem; font-weight: 800; color: var(--heading-color); margin-bottom: 1.25rem; }
    .grid-2 { display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; }
    label { display: block; font-size: .8rem; font-weight: 700; color: var(--label-color); margin-bottom: .35rem; }
    input, select { width: 100%; padding: .65rem .9rem; border: 1.5px solid var(--input-border); border-radius: 9px; font-family: 'Nunito', sans-serif; font-size: .9rem; color: var(--input-color); background: var(--input-bg); outline: none; margin-bottom: .85rem; transition: background .25s, border-color .25s, color .25s; }
    input:focus, select:focus { border-color: #2563EB; box-shadow: 0 0 0 3px rgba(37,99,235,.1); background: var(--input-focus-bg); }
    .btn { padding: .65rem 1.4rem; border-radius: 9px; border: none; cursor: pointer; font-family: 'Nunito', sans-serif; font-weight: 700; font-size: .88rem; transition: .2s; }
    .btn-primary { background: #2563EB; color: #fff; }
    .btn-primary:hover { background: #1D4ED8; }
    .btn-danger  { background: #EF4444; color: #fff; font-size: .78rem; padding: .35rem .8rem; border-radius: 7px; border: none; cursor: pointer; font-family: 'Nunito', sans-serif; font-weight: 700; }
    .btn-success { background: #10B981; color: #fff; }
    .btn-warning { background: #F59E0B; color: #fff; }
    table { width: 100%; border-collapse: collapse; }
    th { background: var(--table-head-bg); font-size: .78rem; font-weight: 800; color: var(--table-head-txt); text-transform: uppercase; letter-spacing: .05em; padding: .75rem 1rem; text-align: left; border-bottom: 1px solid var(--card-border); }
    td { padding: .75rem 1rem; font-size: .88rem; color: var(--body-color); border-bottom: 1px solid var(--table-row-bd); vertical-align: middle; }
    tr:last-child td { border-bottom: none; }
    .badge { display: inline-block; padding: .25rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 700; }
    .badge-ok      { background: #D1FAE5; color: #065F46; }
    .badge-low     { background: #FEF3C7; color: #92400E; }
    .badge-out     { background: #FEE2E2; color: #991B1B; }
    .badge-entrada { background: #DBEAFE; color: #1E40AF; }
    .badge-salida  { background: #FCE7F3; color: #9D174D; }
    .badge-cat     { background: #EDE9FE; color: #5B21B6; font-size: .72rem; padding: .2rem .6rem; }
    .alert-ok  { background: var(--alert-ok-bg); border: 1px solid var(--alert-ok-bd); color: var(--alert-ok-txt); padding: .75rem 1rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: .88rem; }
    .alert-err { background: var(--alert-err-bg); border: 1px solid var(--alert-err-bd); color: var(--alert-err-txt); padding: .75rem 1rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: .88rem; }
    .msg-row { display: flex; gap: 1rem; margin-bottom: 0; }
    .msg-row > div { flex: 1; }
    .w-full { width: 100%; margin-top: .5rem; }
    .filter-bar { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; margin-bottom: 1.1rem; }
    .filter-bar span { font-size: .78rem; font-weight: 800; color: var(--muted-color); text-transform: uppercase; letter-spacing: .05em; margin-right: .25rem; }
    .filter-btn { padding: .3rem .85rem; border-radius: 20px; border: 1.5px solid var(--filter-btn-bd); background: var(--filter-btn-bg); color: var(--filter-btn-txt); font-family: 'Nunito', sans-serif; font-size: .78rem; font-weight: 700; cursor: pointer; transition: .15s; white-space: nowrap; }
    .filter-btn:hover { border-color: #2563EB; color: #2563EB; background: #EFF6FF; }
    .filter-btn.active { background: #2563EB; color: #fff; border-color: #2563EB; }
    .no-results-row { display: none; }
    .no-results-row td { text-align: center; color: var(--muted-color); padding: 2rem; }
</style>

<div class="admin-header">
    <h1 style="display:flex;align-items:center;gap:.5rem;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px;"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
        <span>Inventario de Insumos</span>
    </h1>
    <p>Gestiona el stock de insumos y registra entradas y salidas.</p>
</div>

<?php if (!empty($mensaje)): ?>
    <div class="alert-<?= $mensaje['tipo'] === 'ok' ? 'ok' : 'err' ?>" style="display:flex;align-items:center;gap:.35rem;">
        <?php if ($mensaje['tipo'] === 'ok'): ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; flex-shrink: 0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <?php else: ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; flex-shrink: 0;"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <?php endif; ?>
        <span><?= htmlspecialchars($mensaje['texto']) ?></span>
    </div>
<?php endif; ?>

<div class="grid-2">

    <!-- Columna izquierda: formularios -->
    <div>
        <!-- Nuevo insumo -->
        <div class="card">
            <div class="card-title" style="display:flex;align-items:center;gap:.35rem;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span>Nuevo Insumo</span>
            </div>
            <form method="POST" action="index.php?page=admin_inventario">
                <input type="hidden" name="accion" value="agregar_insumo">
                <label>Nombre</label>
                <input type="text" name="nombre" placeholder="Ej: Leche" required>
                <label>Categoría</label>
                <select name="categoria">
                    <option value="General">General</option>
                    <option value="Sabores de Helado">Sabores de Helado</option>
                    <option value="Toppings Frutas">Toppings Frutas</option>
                    <option value="Toppings Premium">Toppings Premium</option>
                    <option value="Toppings Dulces">Toppings Dulces</option>
                    <option value="Salsas y Untables">Salsas y Untables</option>
                    <option value="Base Waffles">Base Waffles</option>
                    <option value="Base Canastas">Base Canastas</option>
                </select>
                <div class="msg-row">
                    <div>
                        <label>Stock inicial</label>
                        <input type="number" name="stock_actual" step="0.01" min="0" placeholder="0">
                    </div>
                    <div>
                        <label>Stock mínimo</label>
                        <input type="number" name="stock_minimo" step="0.01" min="0" placeholder="0">
                    </div>
                </div>
                <label>Unidad de medida</label>
                <select name="unidad_medida">
                    <option value="kg">kg</option>
                    <option value="g">g</option>
                    <option value="L">L</option>
                    <option value="ml">ml</option>
                    <option value="unidad">unidad</option>
                </select>
                <button type="submit" class="btn btn-primary w-full">Agregar insumo</button>
            </form>
        </div>

        <!-- Registrar movimiento -->
        <div class="card">
            <div class="card-title" style="display:flex;align-items:center;gap:.35rem;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                <span>Registrar Movimiento</span>
            </div>
            <form method="POST" action="index.php?page=admin_inventario">
                <input type="hidden" name="accion" id="accion_mov" value="entrada">
                <label>Insumo</label>
                <select name="idinsumo" required>
                    <option value="">Seleccionar insumo</option>
                    <?php foreach ($insumos as $ins): ?>
                        <option value="<?= $ins['idinsumo'] ?>">
                            <?= htmlspecialchars($ins['nombre']) ?> (<?= number_format($ins['stock_actual'],1) ?> <?= $ins['unidad_medida'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <label>Cantidad</label>
                <input type="number" name="cantidad" step="0.01" min="0.01" placeholder="0" required>
                <div style="display:flex;gap:.75rem;margin-top:.25rem">
                    <button type="submit" class="btn btn-success" style="flex:1;display:inline-flex;align-items:center;justify-content:center;gap:.3rem;"
                            onclick="document.getElementById('accion_mov').value='entrada'"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;"><polyline points="18 15 12 9 6 15"/></svg> Entrada</button>
                    <button type="submit" class="btn btn-warning" style="flex:1;display:inline-flex;align-items:center;justify-content:center;gap:.3rem;"
                            onclick="document.getElementById('accion_mov').value='salida'"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;"><polyline points="6 9 12 15 18 9"/></svg> Salida</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Columna derecha: tablas -->
    <div>
        <!-- Tabla de insumos -->
        <div class="card">
            <div class="card-title" style="display:flex;align-items:center;gap:.35rem;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><polygon points="12 22.08 12 12 3 6.92 3 17.08 12 22.08"/><polygon points="12 22.08 12 12 21 6.92 21 17.08 12 22.08"/><polygon points="12 12 3 6.92 12 1.85 21 6.92 12 12"/></svg>
                <span>Insumos en Stock (<?= count($insumos) ?>)</span>
            </div>

            <div class="filter-bar">
                <span>Filtrar:</span>
                <button class="filter-btn active" data-cat="todas">Todas</button>
                <button class="filter-btn" data-cat="Sabores de Helado">Sabores de Helado</button>
                <button class="filter-btn" data-cat="Toppings Frutas">Toppings Frutas</button>
                <button class="filter-btn" data-cat="Toppings Premium">Toppings Premium</button>
                <button class="filter-btn" data-cat="Toppings Dulces">Toppings Dulces</button>
                <button class="filter-btn" data-cat="Salsas y Untables">Salsas y Untables</button>
                <button class="filter-btn" data-cat="Base Waffles">Base Waffles</button>
                <button class="filter-btn" data-cat="Base Canastas">Base Canastas</button>
                <button class="filter-btn" data-cat="General">General</button>
            </div>

            <table id="tabla-insumos">
                <thead>
                    <tr>
                        <th>Insumo</th>
                        <th>Categoría</th>
                        <th>Stock actual</th>
                        <th>Mínimo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($insumos as $ins): ?>
                    <tr data-categoria="<?= htmlspecialchars($ins['categoria'] ?? 'General') ?>">
                        <td>
                            <strong><?= htmlspecialchars($ins['nombre']) ?></strong><br>
                            <small style="color:var(--muted-color)"><?= htmlspecialchars($ins['unidad_medida']) ?></small>
                        </td>
                        <td>
                            <span class="badge badge-cat"><?= htmlspecialchars($ins['categoria'] ?? 'General') ?></span>
                        </td>
                        <td><?= number_format($ins['stock_actual'], 1) ?></td>
                        <td><?= number_format($ins['stock_minimo'], 1) ?></td>
                        <td>
                            <?php if ($ins['stock_actual'] <= 0): ?>
                                <span class="badge badge-out">Sin stock</span>
                            <?php elseif ($ins['stock_actual'] <= $ins['stock_minimo']): ?>
                                <span class="badge badge-low">Stock bajo</span>
                            <?php else: ?>
                                <span class="badge badge-ok">OK</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="index.php?page=admin_inventario&eliminar_insumo=<?= $ins['idinsumo'] ?>"
                               onclick="return confirm('¿Eliminar este insumo? Se eliminarán también sus movimientos.')"
                               class="btn-danger" style="display:inline-flex;align-items:center;gap:.25rem;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 12px; height: 12px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg> Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($insumos)): ?>
                        <tr><td colspan="6" style="text-align:center;color:var(--muted-color);padding:2rem">Sin insumos registrados</td></tr>
                    <?php endif; ?>
                    <tr class="no-results-row" id="no-results-row">
                        <td colspan="6">No hay insumos en esta categoría.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Últimos movimientos -->
        <div class="card">
            <div class="card-title" style="display:flex;align-items:center;gap:.35rem;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                <span>Últimos 30 movimientos</span>
            </div>
            <table>
                <thead>
                    <tr><th>Insumo</th><th>Tipo</th><th>Cantidad</th><th>Fecha</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($movimientos as $mov): ?>
                    <tr>
                        <td><?= htmlspecialchars($mov['insumo_nombre'] ?? '-') ?></td>
                        <td>
                            <?php if ($mov['tipo_entrada']): ?>
                                <span class="badge badge-entrada" style="display:inline-flex;align-items:center;gap:.2rem;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width: 10px; height: 10px;"><polyline points="18 15 12 9 6 15"/></svg> Entrada</span>
                            <?php else: ?>
                                <span class="badge badge-salida" style="display:inline-flex;align-items:center;gap:.2rem;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width: 10px; height: 10px;"><polyline points="6 9 12 15 18 9"/></svg> Salida</span>
                            <?php endif; ?>
                        </td>
                        <td><?= number_format($mov['cantidad'], 1) ?></td>
                        <td><?= $mov['fecha'] ? date('d/m/Y H:i', strtotime($mov['fecha'])) : '-' ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($movimientos)): ?>
                        <tr><td colspan="4" style="text-align:center;color:var(--muted-color);padding:2rem">Sin movimientos</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
(function () {
    const btns  = document.querySelectorAll('.filter-btn');
    const rows  = document.querySelectorAll('#tabla-insumos tbody tr[data-categoria]');
    const noRes = document.getElementById('no-results-row');

    btns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            btns.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');

            var cat = btn.getAttribute('data-cat');
            var visible = 0;

            rows.forEach(function (row) {
                if (cat === 'todas' || row.getAttribute('data-categoria') === cat) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (noRes) {
                noRes.style.display = visible === 0 ? '' : 'none';
            }
        });
    });
}());
</script>
