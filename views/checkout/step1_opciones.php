<?php
ob_start();

// ── Detectar categoría y nombre ──────────────────────────────────────────────
$cat = strtolower($producto['catalogo'] ?? '');
$np  = strtolower($producto['nombre']   ?? '');

$esYogurt          = str_contains($cat, 'yogurt') || str_contains($cat, 'yogur');
$esEnsalada        = str_contains($cat, 'ensalada');
$esMalteada        = str_contains($cat, 'malteada');
$esCanasta         = str_contains($cat, 'canasta');
$esMalteadaSencilla = $esMalteada && str_contains($np, 'sencilla');
$esMalteadaEspecial = $esMalteada && !$esMalteadaSencilla;

// Detectar Moon Ice (yogurt con reglas especiales)
$esMoonIce = str_contains($np, 'moon ice');

// Sanidad de precio yogurt
$precioMostrar = (float)$producto['precio'];
if ($esYogurt && $precioMostrar < 1000 && $precioMostrar > 0) {
    $precioMostrar = $precioMostrar * 1000;
}

// ── Sabores de helado (canastas y ensaladas) ─────────────────────────────────
$saboresHelado = [
    'Frutos rojos','Maracuya','Chicle','Tres Leches',
    'Coffe Delight','Crema con Mani','Chocolate','Vainilla Chips',
    'Brownie','Arequipe','Uva Vainilla','Lulo',
    'Nucita','Ron con pasas','Mandarina Limon','Acid Mix',
];

// ── Sabores de malteada (22) ─────────────────────────────────────────────────
$saboresMalteada = [
    'Oreo','Frutos rojos','Vainilla chips','Chocolate','Napolitano',
    'Nucita','Cafe','Capuchino','Chicle','Maracuya',
    'Tres leches','Arequipe','Mandarina limon','Uva vainilla','Unicornio',
    'Ron pasas','Lulo','Crema mani','Acid mix','Sandia',
    'Nutella','Kiwi',
];

// ── Configuración de canastas por nombre de producto ────────────────────────
// Retorna ['max' => N, 'precio' => P, 'selector' => bool, 'opciones' => [...]]
function canastaCfg(string $np): array {
    if (str_contains($np, 'mini lasana') || str_contains($np, 'mini lasaña')) {
        return ['max'=>2,'precio'=>15000,'selector'=>false,'opciones'=>[]];
    }
    if (str_contains($np, 'lasana') || str_contains($np, 'lasaña')) {
        return ['max'=>4,'precio'=>19000,'selector'=>false,'opciones'=>[]];
    }
    if (str_contains($np, 'chocorramo')) {
        return ['max'=>3,'precio'=>15000,'selector'=>false,'opciones'=>[]];
    }
    if (str_contains($np, 'oreo')) {
        return ['max'=>3,'precio'=>15000,'selector'=>false,'opciones'=>[]];
    }
    if (str_contains($np, 'chocolatisima') || str_contains($np, 'chocolatísima')) {
        return ['max'=>3,'precio'=>19000,'selector'=>false,'opciones'=>[]];
    }
    if (str_contains($np, 'chicle')) {
        return ['max'=>3,'precio'=>15000,'selector'=>false,'opciones'=>[]];
    }
    if (str_contains($np, 'acida') || str_contains($np, 'ácida')) {
        return ['max'=>3,'precio'=>15000,'selector'=>false,'opciones'=>[],'acida'=>true];
    }
    if (str_contains($np, 'fresura')) {
        return ['max'=>3,'precio'=>19000,'selector'=>false,'opciones'=>[]];
    }
    if (str_contains($np, 'chips')) {
        return ['max'=>3,'precio'=>15000,'selector'=>false,'opciones'=>[]];
    }
    if (str_contains($np, 'toppings')) {
        return ['max'=>3,'precio'=>19000,'selector'=>false,'opciones'=>[]];
    }
    if (str_contains($np, 'especial')) {
        return ['max'=>5,'precio'=>14000,'selector'=>true,'opciones'=>[
            ['sabores'=>4,'precio'=>12000,'label'=>'4 sabores — $12.000'],
            ['sabores'=>5,'precio'=>14000,'label'=>'5 sabores — $14.000'],
        ]];
    }
    if (str_contains($np, 'sencilla')) {
        return ['max'=>3,'precio'=>8000,'selector'=>true,'opciones'=>[
            ['sabores'=>2,'precio'=>7000,'label'=>'2 sabores — $7.000'],
            ['sabores'=>3,'precio'=>8000,'label'=>'3 sabores — $8.000'],
        ]];
    }
    // Fallback genérico
    return ['max'=>3,'precio'=>(int)0,'selector'=>false,'opciones'=>[]];
}

$canastaCfg = $esCanasta ? canastaCfg($np) : [];

// Sabores ácidos para canasta Ácida
$saboresAcidos = ['Maracuya','Lulo','Mandarina Limon','Acid Mix','Uva Vainilla','Chicle'];

// ── Toppings yogurt ──────────────────────────────────────────────────────────
$toppingsFrutas = [
    'Kiwi','Fresas','Cerezas','Duraznos','Mango','Pina','Banano','Pulpa de maracuya',
    'Uvas','Melon','Papaya','Manzana',
];
$toppingsPremium = [
    'Arandanos','Nueces','Almendras','Granola','Queso doble crema',
    'Caviar Lyche','Caviar Maracuya','Caviar Fresa','Caviar Arandanos',
    'Caviar Manzana verde','Caviar Chicle','Caviar Tamarindo','Caviar Cereza',
    'Caviar Naranja','Caviar Sandia','Caviar Mango biche',
];
$toppingsDulces = [
    'Chokis','Galletas oreo','Chocorramo','Gol','Barquillos','Chocolatina nucita',
    'Galletas nucita','Brownie','Jet cookies and cream','Jet barras','Jet wafer',
    'Jet gool','Chips de chocolate','M&M','Fideos de chocolate','Pepitas de chocolate',
    'Zucaritas','Aros Cereal','Choco Krispis','Chocmelos','Chocobreak','Sparkies',
    'Golochips','Galletas Minichips','Ositos Trululu','Gusanos gomitas','Masmelos',
    'Milo','Nuggets de Milo','Pepitas de colores','Chocolatina kinder bueno','Chocolatina Hersheys',
];
$toppingsSalsas  = ['Arequipe','Relleno de Mora','Relleno de Fresa','Chocolate','Lechera'];
$salsasPremium   = ['Syrup de Fresa','Syrup de Caramelo','Syrup de Chocolate'];

// ── Formato COP ──────────────────────────────────────────────────────────────
function cop(float $v): string {
    return '$' . number_format($v, 0, ',', '.');
}
?>

<div class="prod-summary">
    <div class="prod-summary-img">
        <?php if (!empty($producto['imagen'])): ?>
            <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="">
        <?php else: ?>
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none">
                <circle cx="15" cy="11" r="6" fill="#BFDBFE"/>
                <path d="M9 19 Q15 26 21 19" stroke="#93C5FD" stroke-width="2" fill="none" stroke-linecap="round"/>
            </svg>
        <?php endif; ?>
    </div>
    <div>
        <div class="prod-summary-name"><?= htmlspecialchars($producto['nombre']) ?></div>
        <div class="prod-summary-price"><?= cop($precioMostrar) ?></div>
        <?php if (!empty($producto['descripcion'])): ?>
        <div style="font-size:.78rem;color:var(--muted-color);margin-top:.2rem"><?= htmlspecialchars($producto['descripcion']) ?></div>
        <?php endif; ?>
    </div>
</div>

<form method="POST" action="index.php?page=checkout_opciones" id="step1form">
<input type="hidden" name="idproducto" value="<?= $producto['idproducto'] ?>">
<input type="hidden" name="accion" id="accion_form" value="carrito">

<?php /* ══════════════════════════════════════════════════════════════════════
   BLOQUE 1: YOGURT
══════════════════════════════════════════════════════════════════════════════ */
if ($esYogurt): ?>
<style>
.topping-section { margin-bottom:1.25rem; }
.topping-section-title { font-size:.78rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.6rem;display:flex;align-items:center;gap:.5rem; }
.topping-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:.45rem; }
.topping-btn { border:1.5px solid var(--topping-btn-bd);border-radius:9px;background:var(--topping-btn-bg);padding:.45rem .6rem;text-align:center;cursor:pointer;font-family:'Nunito',sans-serif;font-size:.78rem;font-weight:700;color:var(--topping-btn-txt);transition:border-color .12s,background .12s,color .12s;user-select:none; }
.topping-btn:hover { border-color:#94A3B8; }
.topping-btn.sel-frutas  { border-color:#10B981;background:#D1FAE5;color:#065F46; }
.topping-btn.sel-premium { border-color:#8B5CF6;background:#EDE9FE;color:#5B21B6; }
.topping-btn.sel-dulces  { border-color:#F59E0B;background:#FEF3C7;color:#92400E; }
.topping-btn.sel-salsas  { border-color:#EF4444;background:#FEE2E2;color:#991B1B; }
.topping-btn.sel-salsasp { border-color:#EC4899;background:#FCE7F3;color:#9D174D; }
.topping-btn input { display:none; }
.ptag { display:inline-block;font-size:.68rem;font-weight:800;padding:.1rem .4rem;border-radius:20px;margin-left:.3rem; }
.ptag-n { background:#DBEAFE;color:#1D4ED8; }
.ptag-p { background:#EDE9FE;color:#6D28D9; }
.res-box { background:var(--res-box-bg);border:1.5px solid var(--res-box-bd);border-radius:12px;padding:.85rem 1rem;margin-bottom:1rem;min-height:48px;transition:background .25s,border-color .25s; }
.res-title { font-size:.75rem;font-weight:800;color:var(--muted-color);margin-bottom:.4rem; }
.res-chips { display:flex;flex-wrap:wrap;gap:.35rem; }
.chip { display:inline-flex;align-items:center;background:#EFF6FF;color:#1D4ED8;border-radius:20px;padding:.2rem .65rem;font-size:.75rem;font-weight:700; }
.chip.cp { background:#EDE9FE;color:#5B21B6; }
.chip.cs { background:#FEE2E2;color:#991B1B; }
.chip.csp { background:#FCE7F3;color:#9D174D; }
.res-total { font-size:.88rem;font-weight:800;color:var(--heading-color);margin-top:.5rem; }
</style>

<?php if ($esMoonIce): ?>
<div style="background:#FEF3C7;border:1.5px solid #FDE68A;border-radius:12px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.82rem;color:#92400E;font-weight:700">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg> <strong>Moon Ice</strong> — Incluye la base + <strong>4 acompañamientos</strong>.
    Los Toppings Premium tienen un recargo de <strong>$1.000 c/u</strong>.
</div>
<?php else: ?>
<div style="background:#F0FDFA;border:1.5px solid #99F6E4;border-radius:12px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.82rem;color:#0F766E;font-weight:700">
    Frutas y Dulces: <strong>$2.500 c/u</strong> &nbsp;·&nbsp; Premium: <strong>$3.000 c/u</strong> &nbsp;·&nbsp; Salsas: <strong>$2.500 c/u</strong> &nbsp;·&nbsp; Salsas Premium: <strong>$3.000 c/u</strong>
</div>
<?php endif; ?>

<div class="res-box">
    <div class="res-title">Toppings seleccionados <?php if ($esMoonIce): ?><span style="color:#92400E">(max. 4)</span><?php endif; ?></div>
    <div class="res-chips" id="chipsContainer"><span style="color:#94A3B8;font-size:.78rem">Ninguno aún</span></div>
    <div class="res-total" id="totalToppings" style="display:none"></div>
</div>

<div class="topping-section">
    <div class="topping-section-title" style="color:#10B981">Toppings Frutas <span class="ptag ptag-n"><?= $esMoonIce ? 'Incluido' : '$2.500 c/u' ?></span></div>
    <div class="topping-grid">
        <?php foreach ($toppingsFrutas as $t): ?>
        <label class="topping-btn" onclick="tt(this,'frutas')"><input type="checkbox" name="toppings_frutas[]" value="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></label>
        <?php endforeach; ?>
    </div>
</div>
<div class="topping-section">
    <div class="topping-section-title" style="color:#8B5CF6">Toppings Premium <span class="ptag ptag-p"><?= $esMoonIce ? '+$1.000 c/u' : '$3.000 c/u' ?></span></div>
    <div class="topping-grid">
        <?php foreach ($toppingsPremium as $t): ?>
        <label class="topping-btn" onclick="tt(this,'premium')"><input type="checkbox" name="toppings_premium[]" value="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></label>
        <?php endforeach; ?>
    </div>
</div>
<div class="topping-section">
    <div class="topping-section-title" style="color:#F59E0B">Toppings Dulces <span class="ptag ptag-n"><?= $esMoonIce ? 'Incluido' : '$2.500 c/u' ?></span></div>
    <div class="topping-grid">
        <?php foreach ($toppingsDulces as $t): ?>
        <label class="topping-btn" onclick="tt(this,'dulces')"><input type="checkbox" name="toppings_dulces[]" value="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></label>
        <?php endforeach; ?>
    </div>
</div>
<div class="topping-section">
    <div class="topping-section-title" style="color:#EF4444">Salsas <span class="ptag ptag-n"><?= $esMoonIce ? 'Incluido' : '$2.500 c/u' ?></span></div>
    <div class="topping-grid">
        <?php foreach ($toppingsSalsas as $t): ?>
        <label class="topping-btn" onclick="tt(this,'salsas')"><input type="checkbox" name="toppings_salsas[]" value="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></label>
        <?php endforeach; ?>
    </div>
</div>
<div class="topping-section">
    <div class="topping-section-title" style="color:#EC4899">Salsas Premium Hersheys <span class="ptag ptag-p"><?= $esMoonIce ? '+$1.000 c/u' : '$3.000 c/u' ?></span></div>
    <div class="topping-grid">
        <?php foreach ($salsasPremium as $t): ?>
        <label class="topping-btn" onclick="tt(this,'salsasp')"><input type="checkbox" name="toppings_salsasp[]" value="<?= htmlspecialchars($t) ?>"><?= htmlspecialchars($t) ?></label>
        <?php endforeach; ?>
    </div>
</div>

<label>Cantidad</label>
<div style="display:flex;align-items:center;gap:1rem;margin-bottom:.5rem">
    <button type="button" onclick="cq(-1)" class="qty-btn-step">-</button>
    <input type="number" name="cantidad" id="qty" value="1" min="1" max="20" class="qty-input-step" onchange="ar()">
    <button type="button" onclick="cq(1)" class="qty-btn-step">+</button>
</div>
<label>Observaciones <span style="font-weight:400;color:var(--muted-color)">(opcional)</span></label>
<textarea name="observaciones" rows="2" placeholder="Indicaciones especiales..."></textarea>

<script>
var pb = <?= $precioMostrar ?>;
var esMoonIce = <?= $esMoonIce ? 'true' : 'false' ?>;
var maxMoon = 4;
var pm = {frutas:2500, premium:3000, dulces:2500, salsas:2500, salsasp:3000};
var pmMoon = {frutas:0, premium:1000, dulces:0, salsas:0, salsasp:1000};
var cm = {frutas:'sel-frutas', premium:'sel-premium', dulces:'sel-dulces', salsas:'sel-salsas', salsasp:'sel-salsasp'};
var ccm = {frutas:'', premium:'cp', dulces:'', salsas:'cs', salsasp:'csp'};

function contarTodos() {
    var t = 0;
    ['toppings_frutas[]','toppings_premium[]','toppings_dulces[]','toppings_salsas[]','toppings_salsasp[]']
        .forEach(function(n){ t += document.querySelectorAll('input[name="'+n+'"]:checked').length; });
    return t;
}
function tt(lbl, tipo) {
    var inp = lbl.querySelector('input');
    setTimeout(function() {
        if (esMoonIce && inp.checked && contarTodos() > maxMoon) {
            inp.checked = false; lbl.classList.remove(cm[tipo]); ar(); return;
        }
        inp.checked ? lbl.classList.add(cm[tipo]) : lbl.classList.remove(cm[tipo]);
        ar();
    }, 0);
}
function ar() {
    var cc = document.getElementById('chipsContainer');
    var te = document.getElementById('totalToppings');
    var chips = []; var costo = 0;
    var grupos = [
        {n:'toppings_frutas[]',t:'frutas'},
        {n:'toppings_premium[]',t:'premium'},
        {n:'toppings_dulces[]',t:'dulces'},
        {n:'toppings_salsas[]',t:'salsas'},
        {n:'toppings_salsasp[]',t:'salsasp'}
    ];
    grupos.forEach(function(g) {
        document.querySelectorAll('input[name="'+g.n+'"]:checked').forEach(function(i) {
            chips.push({l: i.value, t: g.t});
            costo += esMoonIce ? pmMoon[g.t] : pm[g.t];
        });
    });
    if (!chips.length) {
        cc.innerHTML = '<span style="color:#94A3B8;font-size:.78rem">Ninguno aún</span>';
        te.style.display = 'none';
    } else {
        var avisoMoon = '';
        if (esMoonIce) {
            var restantes = maxMoon - chips.length;
            var color = restantes === 0 ? '#EF4444' : '#0F766E';
            avisoMoon = '<div style="font-size:.75rem;color:'+color+';font-weight:700;margin-top:.4rem">'
                + (restantes > 0
                    ? 'Puedes elegir ' + restantes + ' acompañamiento' + (restantes > 1 ? 's' : '') + ' más'
                    : 'Máximo de 4 acompañamientos alcanzado')
                + '</div>';
        }
        cc.innerHTML = chips.map(function(c){ return '<span class="chip '+ccm[c.t]+'">'+c.l+'</span>'; }).join('') + avisoMoon;
        var q = parseInt(document.getElementById('qty').value) || 1;
        var totalPrecio = (pb + costo) * q;
        te.textContent = 'Total estimado: $' + totalPrecio.toLocaleString('es-CO');
        te.style.display = 'block';
    }
}
function cq(d) {
    var i = document.getElementById('qty');
    var v = parseInt(i.value) + d;
    if (v < 1) v = 1; if (v > 20) v = 20;
    i.value = v; ar();
}
</script>

<?php /* ══════════════════════════════════════════════════════════════════════
   BLOQUE 2: ENSALADA
══════════════════════════════════════════════════════════════════════════════ */
elseif ($esEnsalada): ?>
<style>
.ensalada-tamano-grid { display:grid;grid-template-columns:repeat(3,1fr);gap:.75rem;margin-bottom:1.25rem; }
.ensalada-tam-btn { border:2px solid var(--option-btn-bd);border-radius:14px;background:var(--option-btn-bg);padding:1rem .75rem;text-align:center;cursor:pointer;font-family:'Nunito',sans-serif;transition:border-color .15s,background .15s,color .15s;user-select:none; }
.ensalada-tam-btn:hover { border-color:#F97316; }
.ensalada-tam-btn.sel { border-color:#F97316;background:#FFF7ED; }
.ensalada-tam-btn input { display:none; }
.etam-nombre { font-size:.95rem;font-weight:900;color:var(--heading-color);margin-bottom:.2rem; }
.etam-sabores { font-size:.75rem;font-weight:700;color:#F97316;margin-bottom:.15rem; }
.etam-precio { font-size:1rem;font-weight:900;color:#2563EB; }
.etam-desc { font-size:.72rem;color:var(--muted-color);margin-top:.2rem; }
.sabor-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(145px,1fr));gap:.5rem;margin-bottom:1rem; }
.sabor-btn { border:1.5px solid var(--topping-btn-bd);border-radius:10px;background:var(--topping-btn-bg);padding:.55rem .7rem;text-align:center;cursor:pointer;font-family:'Nunito',sans-serif;font-size:.82rem;font-weight:700;color:var(--topping-btn-txt);transition:border-color .12s,background .12s,color .12s;user-select:none; }
.sabor-btn:hover { border-color:#94A3B8; }
.sabor-btn.sel { border-color:#F97316;background:#FFF7ED;color:#C2410C; }
.sabor-btn input { display:none; }
.sabores-section { display:none; }
.sabores-section.visible { display:block; }
.sabor-aviso { background:#FFF7ED;border:1.5px solid #FED7AA;border-radius:10px;padding:.65rem 1rem;font-size:.82rem;color:#C2410C;font-weight:700;margin-bottom:1rem; }
</style>

<div style="font-size:.8rem;font-weight:800;color:var(--label-color);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.65rem">1. Elige el tamaño</div>
<div class="ensalada-tamano-grid">
    <label class="ensalada-tam-btn" onclick="elegirTamano(this,1,'Mini',15000)">
        <input type="radio" name="tamano_ensalada" value="mini">
        <div class="etam-nombre">Mini</div>
        <div class="etam-sabores">1 sabor de helado</div>
        <div class="etam-precio">$15.000</div>
        <div class="etam-desc">Fruta fresca · salsa · galletas · queso doble crema</div>
    </label>
    <label class="ensalada-tam-btn" onclick="elegirTamano(this,2,'Especial',19000)">
        <input type="radio" name="tamano_ensalada" value="especial">
        <div class="etam-nombre">Especial</div>
        <div class="etam-sabores">2 sabores de helado</div>
        <div class="etam-precio">$19.000</div>
        <div class="etam-desc">Fruta fresca · salsa · galleta · queso doble crema</div>
    </label>
    <label class="ensalada-tam-btn" onclick="elegirTamano(this,3,'Super Especial',25000)">
        <input type="radio" name="tamano_ensalada" value="super_especial">
        <div class="etam-nombre">Super Especial</div>
        <div class="etam-sabores">3 sabores de helado</div>
        <div class="etam-precio">$25.000</div>
        <div class="etam-desc">Fruta fresca · salsa · crema chantilly · galletas · queso doble crema</div>
    </label>
</div>

<div class="sabores-section" id="saboresSection">
    <div class="sabor-aviso" id="saborAviso"></div>
    <div style="font-size:.8rem;font-weight:800;color:var(--label-color);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.65rem">2. Elige tus sabores de helado</div>
    <div class="sabor-grid" id="saborGrid">
        <?php foreach ($saboresHelado as $s): ?>
        <label class="sabor-btn" onclick="ts(this)">
            <input type="checkbox" name="sabores[]" value="<?= htmlspecialchars($s) ?>">
            <?= htmlspecialchars($s) ?>
        </label>
        <?php endforeach; ?>
    </div>
</div>

<label>Cantidad</label>
<div style="display:flex;align-items:center;gap:1rem;margin-bottom:.5rem">
    <button type="button" onclick="cqe(-1)" class="qty-btn-step">-</button>
    <input type="number" name="cantidad" id="qtyE" value="1" min="1" max="20" class="qty-input-step">
    <button type="button" onclick="cqe(1)" class="qty-btn-step">+</button>
</div>
<label>Observaciones <span style="font-weight:400;color:var(--muted-color)">(opcional)</span></label>
<textarea name="observaciones" rows="2" placeholder="Indicaciones especiales para tu ensalada..."></textarea>
<input type="hidden" name="precio_ensalada" id="precioEnsalada" value="">
<input type="hidden" name="tamano" id="tamanoEnsalada" value="">

<script>
var maxSabores = 0;
function elegirTamano(lbl, max, nombre, precio) {
    document.querySelectorAll('.ensalada-tam-btn').forEach(function(b){ b.classList.remove('sel'); });
    lbl.classList.add('sel');
    lbl.querySelector('input').checked = true;
    document.getElementById('precioEnsalada').value = precio;
    document.getElementById('tamanoEnsalada').value = nombre;
    maxSabores = max;
    document.querySelectorAll('#saborGrid input').forEach(function(i){ i.checked = false; });
    document.querySelectorAll('#saborGrid .sabor-btn').forEach(function(b){ b.classList.remove('sel'); });
    document.getElementById('saborAviso').innerHTML =
        '<strong>' + nombre + '</strong> incluye <strong>' + max + ' sabor' + (max>1?'es':'') + ' de helado</strong>';
    document.getElementById('saboresSection').classList.add('visible');
}
function ts(lbl) {
    if (maxSabores === 0) return;
    var inp = lbl.querySelector('input');
    setTimeout(function() {
        var checked = document.querySelectorAll('#saborGrid input:checked');
        if (inp.checked && checked.length > maxSabores) {
            inp.checked = false; lbl.classList.remove('sel'); return;
        }
        inp.checked ? lbl.classList.add('sel') : lbl.classList.remove('sel');
    }, 0);
}
function cqe(d) {
    var i = document.getElementById('qtyE');
    var v = parseInt(i.value) + d;
    if (v < 1) v = 1; if (v > 20) v = 20; i.value = v;
}
</script>

<?php /* ══════════════════════════════════════════════════════════════════════
   BLOQUE 3: MALTEADA SENCILLA
══════════════════════════════════════════════════════════════════════════════ */
elseif ($esMalteadaSencilla): ?>
<style>
.malt-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:.5rem;margin-bottom:1rem; }
.malt-btn { border:1.5px solid var(--topping-btn-bd);border-radius:10px;background:var(--topping-btn-bg);padding:.55rem .7rem;text-align:center;cursor:pointer;font-family:'Nunito',sans-serif;font-size:.82rem;font-weight:700;color:var(--topping-btn-txt);transition:border-color .12s,background .12s,color .12s;user-select:none; }
.malt-btn:hover { border-color:#94A3B8; }
.malt-btn.sel { border-color:#7C3AED;background:#EDE9FE;color:#5B21B6; }
.malt-btn input { display:none; }
/* Botones de cantidad compartidos */
.qty-btn-step { width:38px;height:38px;border-radius:9px;border:1.5px solid var(--input-border);background:var(--input-bg);font-size:1.2rem;font-weight:800;cursor:pointer;color:var(--heading-color);transition:background .15s,border-color .25s; }
.qty-input-step { width:80px;text-align:center;font-weight:800;font-size:1.1rem; }
</style>

<div style="background:#F5F3FF;border:1.5px solid #DDD6FE;border-radius:12px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.82rem;color:#5B21B6;font-weight:700">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"><path d="M6 10h12l-1 11H7z"/><path d="M9 10V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v5"/><path d="M6 10h12"/></svg> <strong>Malteada Sencilla</strong> — Elige <strong>1 sabor</strong>. Precio fijo: <strong>$13.000</strong>
</div>

<div style="font-size:.8rem;font-weight:800;color:var(--label-color);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.65rem">Elige tu sabor</div>
<div class="malt-grid">
    <?php foreach ($saboresMalteada as $s): ?>
    <label class="malt-btn" onclick="selSaborMalt(this)">
        <input type="radio" name="sabores[]" value="<?= htmlspecialchars($s) ?>" required>
        <?= htmlspecialchars($s) ?>
    </label>
    <?php endforeach; ?>
</div>
<input type="hidden" name="precio_malteada" value="13000">

<label>Cantidad</label>
<div style="display:flex;align-items:center;gap:1rem;margin-bottom:.5rem">
    <button type="button" onclick="cqm(-1)" class="qty-btn-step">-</button>
    <input type="number" name="cantidad" id="qtyM" value="1" min="1" max="20" class="qty-input-step">
    <button type="button" onclick="cqm(1)" class="qty-btn-step">+</button>
</div>
<label>Observaciones <span style="font-weight:400;color:var(--muted-color)">(opcional)</span></label>
<textarea name="observaciones" rows="2" placeholder="Indicaciones especiales para tu malteada..."></textarea>

<script>
function selSaborMalt(lbl) {
    document.querySelectorAll('.malt-btn').forEach(function(b){ b.classList.remove('sel'); });
    lbl.classList.add('sel');
}
function cqm(d) {
    var i = document.getElementById('qtyM');
    var v = parseInt(i.value) + d;
    if (v < 1) v = 1; if (v > 20) v = 20; i.value = v;
}
</script>

<?php /* ══════════════════════════════════════════════════════════════════════
   BLOQUE 4: MALTEADA ESPECIAL (Baileys, Nutella, Yogurt, Kiwi)
   Solo cantidad, precio fijo del producto
══════════════════════════════════════════════════════════════════════════════ */
elseif ($esMalteadaEspecial): ?>
<div style="background:#FFF7ED;border:1.5px solid #FED7AA;border-radius:12px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.82rem;color:#C2410C;font-weight:700">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"><path d="M6 10h12l-1 11H7z"/><path d="M9 10V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v5"/><path d="M6 10h12"/></svg> <strong>Malteada Especial</strong> — Precio fijo: <strong><?= cop($precioMostrar) ?></strong>
</div>
<div style="background:var(--res-box-bg);border:1.5px solid var(--res-box-bd);border-radius:12px;padding:.85rem 1rem;margin-bottom:1.25rem;font-size:.85rem;color:var(--body-color);font-weight:700">
    Sabor: <strong><?= htmlspecialchars($producto['nombre']) ?></strong>
</div>

<label>Cantidad</label>
<div style="display:flex;align-items:center;gap:1rem;margin-bottom:.5rem">
    <button type="button" onclick="cqme(-1)" class="qty-btn-step">-</button>
    <input type="number" name="cantidad" id="qtyME" value="1" min="1" max="20" class="qty-input-step">
    <button type="button" onclick="cqme(1)" class="qty-btn-step">+</button>
</div>
<label>Observaciones <span style="font-weight:400;color:var(--muted-color)">(opcional)</span></label>
<textarea name="observaciones" rows="2" placeholder="Indicaciones especiales..."></textarea>

<script>
function cqme(d) {
    var i = document.getElementById('qtyME');
    var v = parseInt(i.value) + d;
    if (v < 1) v = 1; if (v > 20) v = 20; i.value = v;
}
</script>

<?php /* ══════════════════════════════════════════════════════════════════════
   BLOQUE 5: CANASTA
══════════════════════════════════════════════════════════════════════════════ */
elseif ($esCanasta):
    $tieneSelector = !empty($canastaCfg['selector']) && !empty($canastaCfg['opciones']);
    $esAcida       = !empty($canastaCfg['acida']);
    $listaSabores  = $esAcida ? $saboresAcidos : $saboresHelado;
    $maxCanasta    = (int)($canastaCfg['max'] ?? 3);
    $precioCanasta = (int)($canastaCfg['precio'] ?? $precioMostrar);
?>
<style>
.canasta-opcion-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:.75rem;margin-bottom:1.25rem; }
.canasta-opcion-btn { border:2px solid var(--option-btn-bd);border-radius:14px;background:var(--option-btn-bg);padding:.9rem .75rem;text-align:center;cursor:pointer;font-family:'Nunito',sans-serif;transition:border-color .15s,background .15s,color .15s;user-select:none; }
.canasta-opcion-btn:hover { border-color:#0D9488; }
.canasta-opcion-btn.sel { border-color:#0D9488;background:#F0FDFA; }
.canasta-opcion-btn input { display:none; }
.cop-label { font-size:.95rem;font-weight:900;color:var(--heading-color);margin-bottom:.2rem; }
.cop-precio { font-size:1rem;font-weight:900;color:#0D9488; }
.canasta-sabor-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(145px,1fr));gap:.5rem;margin-bottom:1rem; }
.canasta-sabor-btn { border:1.5px solid var(--topping-btn-bd);border-radius:10px;background:var(--topping-btn-bg);padding:.55rem .7rem;text-align:center;cursor:pointer;font-family:'Nunito',sans-serif;font-size:.82rem;font-weight:700;color:var(--topping-btn-txt);transition:border-color .12s,background .12s,color .12s;user-select:none; }
.canasta-sabor-btn:hover { border-color:#94A3B8; }
.canasta-sabor-btn.sel { border-color:#0D9488;background:#F0FDFA;color:#0F766E; }
.canasta-sabor-btn input { display:none; }
.canasta-sabores-wrap { display:none; }
.canasta-sabores-wrap.visible { display:block; }
.canasta-aviso { background:#F0FDFA;border:1.5px solid #99F6E4;border-radius:10px;padding:.65rem 1rem;font-size:.82rem;color:#0F766E;font-weight:700;margin-bottom:1rem; }
</style>

<div style="background:#F0FDFA;border:1.5px solid #99F6E4;border-radius:12px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.82rem;color:#0F766E;font-weight:700">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 4px;"><path d="M22 12h-6l-3 3-3-3H2v10h20V12z"/><path d="M5.45 5.11L2 12v6h20v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg> <strong>Canasta <?= htmlspecialchars($producto['nombre']) ?></strong>
    <?php if (!$tieneSelector): ?>
     — <?= $maxCanasta ?> sabor<?= $maxCanasta > 1 ? 'es' : '' ?> de helado · <strong><?= cop($precioCanasta) ?></strong>
    <?php endif; ?>
    <?php if ($esAcida): ?> &nbsp;·&nbsp; <span style="color:#7C3AED">Solo sabores ácidos</span><?php endif; ?>
</div>

<?php if ($tieneSelector): ?>
<!-- Selector de precio/sabores para Sencilla y Especial -->
<div style="font-size:.8rem;font-weight:800;color:var(--label-color);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.65rem">1. Elige la opción</div>
<div class="canasta-opcion-grid">
    <?php foreach ($canastaCfg['opciones'] as $idx => $op): ?>
    <label class="canasta-opcion-btn" onclick="elegirOpcionCanasta(this,<?= (int)$op['sabores'] ?>,<?= (int)$op['precio'] ?>)">
        <input type="radio" name="canasta_opcion" value="<?= (int)$op['sabores'] ?>">
        <div class="cop-label"><?= (int)$op['sabores'] ?> sabores</div>
        <div class="cop-precio"><?= cop($op['precio']) ?></div>
    </label>
    <?php endforeach; ?>
</div>
<input type="hidden" name="precio_canasta" id="precioCanasta" value="">
<div class="canasta-sabores-wrap" id="canastaSaboresWrap">
    <div class="canasta-aviso" id="canastaAviso"></div>
    <div style="font-size:.8rem;font-weight:800;color:var(--label-color);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.65rem">2. Elige tus sabores de helado</div>
    <div class="canasta-sabor-grid" id="canastaSaborGrid">
        <?php foreach ($listaSabores as $s): ?>
        <label class="canasta-sabor-btn" onclick="tsCanasta(this)">
            <input type="checkbox" name="sabores[]" value="<?= htmlspecialchars($s) ?>">
            <?= htmlspecialchars($s) ?>
        </label>
        <?php endforeach; ?>
    </div>
</div>
<script>
var maxCanasta = 0;
function elegirOpcionCanasta(lbl, max, precio) {
    document.querySelectorAll('.canasta-opcion-btn').forEach(function(b){ b.classList.remove('sel'); });
    lbl.classList.add('sel');
    lbl.querySelector('input').checked = true;
    document.getElementById('precioCanasta').value = precio;
    maxCanasta = max;
    document.querySelectorAll('#canastaSaborGrid input').forEach(function(i){ i.checked = false; });
    document.querySelectorAll('#canastaSaborGrid .canasta-sabor-btn').forEach(function(b){ b.classList.remove('sel'); });
    document.getElementById('canastaAviso').innerHTML =
        'Elige <strong>' + max + ' sabor' + (max>1?'es':'') + ' de helado</strong>';
    document.getElementById('canastaSaboresWrap').classList.add('visible');
}
function tsCanasta(lbl) {
    if (maxCanasta === 0) return;
    var inp = lbl.querySelector('input');
    setTimeout(function() {
        var checked = document.querySelectorAll('#canastaSaborGrid input:checked');
        if (inp.checked && checked.length > maxCanasta) {
            inp.checked = false; lbl.classList.remove('sel'); return;
        }
        inp.checked ? lbl.classList.add('sel') : lbl.classList.remove('sel');
    }, 0);
}
</script>

<?php else: ?>
<!-- Canasta con max fijo, sin selector -->
<input type="hidden" name="precio_canasta" value="<?= $precioCanasta ?>">
<div class="canasta-aviso">Elige <strong><?= $maxCanasta ?> sabor<?= $maxCanasta > 1 ? 'es' : '' ?> de helado</strong><?= $esAcida ? ' (solo sabores ácidos)' : '' ?></div>
<div class="canasta-sabor-grid" id="canastaSaborGrid">
    <?php foreach ($listaSabores as $s): ?>
    <label class="canasta-sabor-btn" onclick="tsCanasta(this)">
        <input type="checkbox" name="sabores[]" value="<?= htmlspecialchars($s) ?>">
        <?= htmlspecialchars($s) ?>
    </label>
    <?php endforeach; ?>
</div>
<script>
var maxCanasta = <?= $maxCanasta ?>;
function tsCanasta(lbl) {
    var inp = lbl.querySelector('input');
    setTimeout(function() {
        var checked = document.querySelectorAll('#canastaSaborGrid input:checked');
        if (inp.checked && checked.length > maxCanasta) {
            inp.checked = false; lbl.classList.remove('sel'); return;
        }
        inp.checked ? lbl.classList.add('sel') : lbl.classList.remove('sel');
    }, 0);
}
</script>
<?php endif; ?>

<label>Cantidad</label>
<div style="display:flex;align-items:center;gap:1rem;margin-bottom:.5rem">
    <button type="button" onclick="cqcan(-1)" class="qty-btn-step">-</button>
    <input type="number" name="cantidad" id="qtyCan" value="1" min="1" max="20" class="qty-input-step">
    <button type="button" onclick="cqcan(1)" class="qty-btn-step">+</button>
</div>
<label>Observaciones <span style="font-weight:400;color:var(--muted-color)">(opcional)</span></label>
<textarea name="observaciones" rows="2" placeholder="Indicaciones especiales para tu canasta..."></textarea>
<script>
function cqcan(d) {
    var i = document.getElementById('qtyCan');
    var v = parseInt(i.value) + d;
    if (v < 1) v = 1; if (v > 20) v = 20; i.value = v;
}
</script>

<?php /* ══════════════════════════════════════════════════════════════════════
   BLOQUE ELSE: Genérico (fallback)
══════════════════════════════════════════════════════════════════════════════ */
else: ?>
<label>Cantidad</label>
<div style="display:flex;align-items:center;gap:1rem;margin-bottom:.5rem">
    <button type="button" onclick="cqg(-1)" class="qty-btn-step">-</button>
    <input type="number" name="cantidad" id="qtyG" value="1" min="1" max="20" class="qty-input-step">
    <button type="button" onclick="cqg(1)" class="qty-btn-step">+</button>
</div>
<label>Observaciones <span style="font-weight:400;color:var(--muted-color)">(opcional)</span></label>
<textarea name="observaciones" rows="2" placeholder="Indicaciones especiales..."></textarea>
<script>
function cqg(d){var i=document.getElementById('qtyG');var v=parseInt(i.value)+d;if(v<1)v=1;if(v>20)v=20;i.value=v;}
</script>
<?php endif; ?>

<div style="display:flex;gap:.75rem;margin-top:1.25rem">
    <button type="submit" class="btn-next" style="flex:1;background:#0D9488;display:inline-flex;align-items:center;justify-content:center;"
            onclick="document.getElementById('accion_form').value='carrito'">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 15px; height: 15px; margin-right: 5px;"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg> Agregar al carrito
    </button>
    <button type="submit" class="btn-next" style="flex:1;display:inline-flex;align-items:center;justify-content:center;"
            onclick="document.getElementById('accion_form').value='pedir'">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="width: 15px; height: 15px; margin-right: 5px;"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg> Pedir ahora
    </button>
</div>
</form>

<?php
$step_content = ob_get_clean();
if ($esYogurt)              $step_title = 'Personaliza tu Helado de Yogurt';
elseif ($esEnsalada)        $step_title = 'Elige tus sabores de helado';
elseif ($esMalteadaSencilla) $step_title = 'Elige el sabor de tu Malteada';
elseif ($esMalteadaEspecial) $step_title = 'Malteada Especial';
elseif ($esCanasta)         $step_title = 'Arma tu Canasta';
else                        $step_title = 'Personaliza tu pedido';
$step = 1;
include __DIR__ . '/step_layout.php';
