<style>
    .admin-header { margin-bottom: 1.75rem; }
    .admin-header h1 { display: flex; align-items: center; gap: .5rem; font-size: 1.6rem; font-weight: 900; color: var(--heading-color); margin-bottom: .3rem; }
    .admin-header h1 svg { width: 28px; height: 28px; color: #2563EB; }
    .admin-header p { color: var(--muted-color); font-size: .93rem; }
    .grid-2 { display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; }
    .card { background: var(--card-bg); border-radius: 16px; box-shadow: var(--card-shadow); padding: 1.5rem; margin-bottom: 1.5rem; border: 1px solid var(--card-border); transition: background .25s, border-color .25s; }
    .card-title { display: flex; align-items: center; gap: .4rem; font-size: 1.05rem; font-weight: 800; color: var(--heading-color); margin-bottom: 1.25rem; }
    .card-title svg { width: 18px; height: 18px; color: #2563EB; }
    label { display: block; font-size: .8rem; font-weight: 700; color: var(--label-color); margin-bottom: .35rem; }
    input { width: 100%; padding: .65rem .9rem; border: 1.5px solid var(--input-border); border-radius: 9px; font-family: 'Nunito', sans-serif; font-size: .9rem; background: var(--input-bg); outline: none; margin-bottom: .85rem; color: var(--input-color); transition: background .25s, border-color .25s, color .25s; }
    input:focus { border-color: #2563EB; box-shadow: 0 0 0 3px rgba(37,99,235,.1); background: var(--input-focus-bg); }
    .btn { padding: .65rem 1.4rem; border-radius: 9px; border: none; cursor: pointer; font-family: 'Nunito', sans-serif; font-weight: 700; font-size: .88rem; }
    .btn-primary { background: #2563EB; color: #fff; width: 100%; }
    .btn-danger { display: inline-flex; align-items: center; gap: .25rem; background: #EF4444; color: #fff; font-size: .78rem; padding: .35rem .8rem; border-radius: 7px; border: none; cursor: pointer; font-family: 'Nunito', sans-serif; font-weight: 700; text-decoration: none; }
    table { width: 100%; border-collapse: collapse; }
    th { background: var(--table-head-bg); font-size: .78rem; font-weight: 800; color: var(--table-head-txt); text-transform: uppercase; letter-spacing: .05em; padding: .75rem 1rem; text-align: left; border-bottom: 1px solid var(--card-border); }
    td { padding: .75rem 1rem; font-size: .88rem; color: var(--body-color); border-bottom: 1px solid var(--table-row-bd); }
    tr:last-child td { border-bottom: none; }
    .alert-ok { display: flex; align-items: center; gap: .5rem; background: var(--alert-ok-bg); border: 1px solid var(--alert-ok-bd); color: var(--alert-ok-txt); padding: .75rem 1rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: .88rem; }
</style>

<div class="admin-header">
    <h1>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        Proveedores
    </h1>
    <p>Gestiona los proveedores de insumos de la heladería.</p>
</div>

<?php if (!empty($mensaje)): ?>
    <div class="alert-ok">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;flex-shrink:0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <span><?= htmlspecialchars($mensaje) ?></span>
    </div>
<?php endif; ?>

<div class="grid-2">
    <div class="card">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nuevo Proveedor
        </div>
        <form method="POST" action="index.php?page=admin_proveedores">
            <label>Nombre</label>
            <input type="text" name="nombre" placeholder="Nombre del proveedor" required>
            <label>Teléfono</label>
            <input type="text" name="telefono" placeholder="Ej: 3001234567">
            <label>Correo</label>
            <input type="email" name="correo" placeholder="proveedor@correo.com">
            <button type="submit" class="btn btn-primary">Guardar proveedor</button>
        </form>
    </div>

    <div class="card">
        <div class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="9" y1="9" x2="15" y2="9"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="13" y2="17"/></svg>
            Proveedores Registrados
        </div>
        <table>
            <thead>
                <tr><th>Nombre</th><th>Teléfono</th><th>Correo</th><th>Acciones</th></tr>
            </thead>
            <tbody>
                <?php foreach ($proveedores as $p): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
                    <td><?= htmlspecialchars($p['telefono'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($p['correo'] ?? '-') ?></td>
                    <td>
                        <a href="index.php?page=admin_proveedores&eliminar=<?= $p['idproveedor'] ?>"
                           onclick="return confirm('¿Eliminar proveedor?')"
                           class="btn-danger">
                           <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:13px;height:13px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                           Eliminar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($proveedores)): ?>
                    <tr><td colspan="4" style="text-align:center;color:var(--muted-color);padding:2rem">Sin proveedores</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
