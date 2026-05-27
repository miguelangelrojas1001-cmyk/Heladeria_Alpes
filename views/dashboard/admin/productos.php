<style>
    .admin-header { margin-bottom: 1.75rem; }
    .admin-header h1 { font-size: 1.6rem; font-weight: 900; color: var(--heading-color); margin-bottom: .3rem; }
    .admin-header p { color: var(--muted-color); font-size: .93rem; }
    .card { background: var(--card-bg); border-radius: 16px; box-shadow: var(--card-shadow); padding: 1.5rem; margin-bottom: 1.5rem; border: 1px solid var(--card-border); transition: background .25s, border-color .25s; }
    .card-title { font-size: 1.05rem; font-weight: 800; color: var(--heading-color); margin-bottom: 1.25rem; }
    label { display: block; font-size: .8rem; font-weight: 700; color: var(--label-color); margin-bottom: .35rem; }
    input, select, textarea { width: 100%; padding: .65rem .9rem; border: 1.5px solid var(--input-border); border-radius: 9px; font-family: 'Nunito', sans-serif; font-size: .9rem; background: var(--input-bg); outline: none; margin-bottom: .85rem; color: var(--input-color); transition: background .25s, border-color .25s, color .25s; }
    input:focus, select:focus, textarea:focus { border-color: #2563EB; background: var(--input-focus-bg); }
    .btn-primary { background: #2563EB; color: #fff; width: 100%; padding: .75rem; border-radius: 10px; border: none; cursor: pointer; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: .95rem; margin-top: .5rem; }
    .btn-secondary { background: var(--btn-sec-bg); color: var(--btn-sec-txt); width: 100%; padding: .65rem; border-radius: 10px; border: none; cursor: pointer; font-family: 'Nunito', sans-serif; font-weight: 700; font-size: .88rem; margin-top: .4rem; text-decoration: none; display: block; text-align: center; transition: background .15s; }
    .btn-secondary:hover { background: var(--btn-sec-hover); }
    .badge { display: inline-block; padding: .25rem .75rem; border-radius: 20px; font-size: .75rem; font-weight: 700; }
    .badge-ok { background: #D1FAE5; color: #065F46; }
    .badge-no { background: #FEE2E2; color: #991B1B; }
    .alert-ok { background: var(--alert-ok-bg); border: 1px solid var(--alert-ok-bd); color: var(--alert-ok-txt); padding: .75rem 1rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: .88rem; }
    .alert-err { background: var(--alert-err-bg); border: 1px solid var(--alert-err-bd); color: var(--alert-err-txt); padding: .75rem 1rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: .88rem; }
    .prod-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px,1fr)); gap: 1rem; }
    .prod-card { border: 1.5px solid var(--card-border); border-radius: 14px; overflow: hidden; transition: box-shadow .2s, border-color .25s; background: var(--card-bg); }
    .prod-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.15); }
    .prod-img { width: 100%; height: 120px; background: var(--prod-img-bg); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; overflow: hidden; transition: background .25s; }
    .prod-img img { width: 100%; height: 100%; object-fit: cover; }
    .prod-body { padding: .85rem; }
    .prod-name { font-weight: 800; color: var(--heading-color); font-size: .9rem; }
    .prod-cat { font-size: .75rem; color: var(--muted-color); }
    .prod-price { font-size: 1rem; font-weight: 900; color: #2563EB; margin-top: .3rem; }
    .prod-foot { display: flex; justify-content: space-between; align-items: center; margin-top: .65rem; gap: .4rem; flex-wrap: wrap; }
    .btn-del { background: #FEE2E2; color: #EF4444; border: none; border-radius: 8px; padding: .3rem .75rem; font-size: .78rem; font-weight: 700; cursor: pointer; font-family: 'Nunito', sans-serif; text-decoration: none; }
    .btn-edit { background: #EFF6FF; color: #2563EB; border: none; border-radius: 8px; padding: .3rem .75rem; font-size: .78rem; font-weight: 700; cursor: pointer; font-family: 'Nunito', sans-serif; text-decoration: none; }
    .edit-banner { background: var(--edit-banner-bg); border: 1.5px solid var(--edit-banner-bd); border-radius: 10px; padding: .75rem 1rem; margin-bottom: 1rem; font-size: .88rem; color: var(--edit-banner-txt); font-weight: 700; }
    .layout-productos { display: grid; grid-template-columns: 320px 1fr; gap: 1.5rem; align-items: start; }
    .filter-bar { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; margin-bottom: 1.1rem; }
    .filter-bar span { font-size: .78rem; font-weight: 800; color: var(--muted-color); text-transform: uppercase; letter-spacing: .05em; }
    .filter-btn { padding: .3rem .85rem; border-radius: 20px; border: 1.5px solid var(--filter-btn-bd); background: var(--filter-btn-bg); color: var(--filter-btn-txt); font-family: 'Nunito', sans-serif; font-size: .78rem; font-weight: 700; cursor: pointer; transition: .15s; white-space: nowrap; }
    .filter-btn:hover { border-color: #2563EB; color: #2563EB; background: #EFF6FF; }
    .filter-btn.active { background: #2563EB; color: #fff; border-color: #2563EB; }
</style>

<div class="admin-header">
    <h1 style="display:flex;align-items:center;gap:.5rem;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 24px; height: 24px;"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><polygon points="12 22.08 12 12 3 6.92 3 17.08 12 22.08"/><polygon points="12 22.08 12 12 21 6.92 21 17.08 12 22.08"/><polygon points="12 12 3 6.92 12 1.85 21 6.92 12 12"/></svg>
        <span>Productos</span>
    </h1>
    <p>Agrega y gestiona los productos de la heladería.</p>
</div>

<?php if (!empty($mensaje)): ?>
    <div class="<?= str_contains($mensaje, 'Error') ? 'alert-err' : 'alert-ok' ?>" style="display:flex;align-items:center;gap:.35rem;">
        <?php if (str_contains($mensaje, 'Error')): ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; flex-shrink: 0;"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <?php else: ?>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; flex-shrink: 0;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        <?php endif; ?>
        <span><?= htmlspecialchars($mensaje) ?></span>
    </div>
<?php endif; ?>

<div class="layout-productos">
    <!-- Formulario izquierda -->
    <div class="card">
        <?php if ($productoEditar): ?>
            <div class="edit-banner" style="display:flex;align-items:center;gap:.35rem;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                <span>Editando: <?= htmlspecialchars($productoEditar['nombre']) ?></span>
            </div>
            <div class="card-title" style="display:flex;align-items:center;gap:.35rem;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                <span>Editar Producto</span>
            </div>
            <form method="POST" action="index.php?page=admin_productos" enctype="multipart/form-data">
                <input type="hidden" name="_editar" value="<?= $productoEditar['idproducto'] ?>">
                <label>Categoría</label>
                <select name="idcatalogo" required>
                    <option value="">Seleccionar categoría</option>
                    <?php foreach ($catalogos as $cat): ?>
                        <option value="<?= $cat['idcatalogo'] ?>" <?= $cat['idcatalogo'] == $productoEditar['idcatalogo'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label>Nombre</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($productoEditar['nombre']) ?>" required>
                <label>Descripción</label>
                <textarea name="descripcion" rows="2"><?= htmlspecialchars($productoEditar['descripcion'] ?? '') ?></textarea>
                <label>Precio (en pesos, ej: 15000)</label>
                <input type="number" name="precio" step="1" min="0" value="<?= $productoEditar['precio'] ?>" required>
                <label>Imagen <span style="font-weight:400;color:var(--muted-color)">(vacío = mantener actual)</span></label>
                <input type="file" name="imagen" accept="image/*">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;margin-bottom:.85rem">
                    <input type="checkbox" name="disponible" <?= $productoEditar['disponible'] ? 'checked' : '' ?> style="width:auto;margin-bottom:0">
                    <span>Producto disponible</span>
                </label>
                <button type="submit" class="btn-primary">Guardar cambios</button>
                <a href="index.php?page=admin_productos" class="btn-secondary">Cancelar</a>
            </form>
        <?php else: ?>
            <div class="card-title" style="display:flex;align-items:center;gap:.35rem;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span>Nuevo Producto</span>
            </div>
            <form method="POST" action="index.php?page=admin_productos" enctype="multipart/form-data">
                <label>Categoría</label>
                <select name="idcatalogo" required>
                    <option value="">Seleccionar categoría</option>
                    <?php foreach ($catalogos as $cat): ?>
                        <option value="<?= $cat['idcatalogo'] ?>"><?= htmlspecialchars($cat['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Nombre</label>
                <input type="text" name="nombre" placeholder="Nombre del producto" required>
                <label>Descripción</label>
                <textarea name="descripcion" rows="2" placeholder="Descripción breve..."></textarea>
                <label>Precio (en pesos, ej: 15000)</label>
                <input type="number" name="precio" step="1" min="0" placeholder="15000" required>
                <label>Imagen</label>
                <input type="file" name="imagen" accept="image/*">
                <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;margin-bottom:.85rem">
                    <input type="checkbox" name="disponible" checked style="width:auto;margin-bottom:0">
                    <span>Producto disponible</span>
                </label>
                <button type="submit" class="btn-primary">Guardar producto</button>
            </form>
        <?php endif; ?>
    </div>

    <!-- Listado derecha -->
    <div class="card">
        <div class="card-title">Productos registrados (<?= count($productos) ?>)</div>

        <!-- Filtro por categoría -->
        <div class="filter-bar">
            <span>Filtrar:</span>
            <button class="filter-btn active" data-cat="todas">Todas</button>
            <?php
            $cats_unicas = array_unique(array_column($productos, 'catalogo'));
            sort($cats_unicas);
            foreach ($cats_unicas as $cn):
                if ($cn):
            ?>
            <button class="filter-btn" data-cat="<?= htmlspecialchars($cn) ?>"><?= htmlspecialchars($cn) ?></button>
            <?php endif; endforeach; ?>
        </div>

        <?php if (!empty($productos)): ?>
        <div class="prod-grid" id="prod-grid">
            <?php foreach ($productos as $p): ?>
            <div class="prod-card" data-catalogo="<?= htmlspecialchars($p['catalogo'] ?? '') ?>">
                <div class="prod-img">
                    <?php if (!empty($p['imagen'])): ?>
                        <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
                    <?php else: ?>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 32px; height: 32px; color: var(--muted-color);"><path d="M12 2a5 5 0 0 0-5 5v3a5 5 0 0 0 10 0V7a5 5 0 0 0-5-5z"/><path d="M6 10l6 11 6-11"/></svg>
                    <?php endif; ?>
                </div>
                <div class="prod-body">
                    <div class="prod-name"><?= htmlspecialchars($p['nombre']) ?></div>
                    <div class="prod-cat"><?= htmlspecialchars($p['catalogo'] ?? 'Sin categoría') ?></div>
                    <div class="prod-price">$<?= number_format($p['precio'], 0, ',', '.') ?></div>
                    <div class="prod-foot">
                        <span class="badge <?= $p['disponible'] ? 'badge-ok' : 'badge-no' ?>">
                            <?= $p['disponible'] ? 'Disponible' : 'No disponible' ?>
                        </span>
                        <div style="display:flex;gap:.35rem">
                            <a href="index.php?page=admin_productos&editar=<?= $p['idproducto'] ?>" class="btn-edit" style="display:inline-flex;align-items:center;gap:.2rem;"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 12px; height: 12px;"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg> Editar</a>
                            <a href="index.php?page=admin_productos&eliminar=<?= $p['idproducto'] ?>"
                               onclick="return confirm('¿Eliminar este producto?')" class="btn-del">Eliminar</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
            <p style="color:var(--muted-color);text-align:center;padding:2rem 0">Sin productos registrados aún.</p>
        <?php endif; ?>
    </div>
</div>

<script>
(function(){
    var btns = document.querySelectorAll('.filter-btn');
    var cards = document.querySelectorAll('#prod-grid .prod-card');
    btns.forEach(function(btn){
        btn.addEventListener('click', function(){
            btns.forEach(function(b){ b.classList.remove('active'); });
            btn.classList.add('active');
            var cat = btn.getAttribute('data-cat');
            cards.forEach(function(card){
                if(cat === 'todas' || card.getAttribute('data-catalogo') === cat){
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
}());
</script>
