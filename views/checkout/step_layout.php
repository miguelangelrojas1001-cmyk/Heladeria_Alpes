<?php
// step_layout.php — renders $step_content inside a stepper shell
// Required vars: $step (1-4), $step_title, $step_content, $producto
$steps = ['Personaliza', 'Entrega', 'Pago', 'Confirmación'];
?>
<style>
.ck-wrap { max-width: 760px; margin: 0 auto; }
.ck-steps { display: flex; align-items: center; margin-bottom: 2rem; }
.ck-step { display: flex; align-items: center; gap: .5rem; flex: 1; }
.ck-step-num {
    width: 32px; height: 32px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .82rem; font-weight: 800; flex-shrink: 0;
    transition: background .2s;
}
.ck-step.done .ck-step-num  { background: #2563EB; color: #fff; }
.ck-step.active .ck-step-num{ background: #2563EB; color: #fff; box-shadow: 0 0 0 4px rgba(37,99,235,.2); }
.ck-step.todo .ck-step-num  { background: var(--ck-step-todo); color: var(--ck-step-todo-txt); }
.ck-step-label { font-size: .8rem; font-weight: 700; color: var(--muted-color); }
.ck-step.active .ck-step-label { color: #2563EB; }
.ck-step.done .ck-step-label  { color: var(--heading-color); }
.ck-divider { flex: 1; height: 2px; background: var(--ck-divider); margin: 0 .5rem; transition: background .25s; }
.ck-divider.done { background: #2563EB; }
.ck-card { background: var(--ck-card-bg); border-radius: 18px; box-shadow: var(--card-shadow); padding: 2rem; border: 1px solid var(--card-border); transition: background .25s, border-color .25s; }
.ck-title { font-size: 1.3rem; font-weight: 900; color: var(--heading-color); margin-bottom: 1.5rem; }
label { display: block; font-size: .8rem; font-weight: 700; color: var(--label-color); margin-bottom: .35rem; margin-top: .75rem; }
input, select, textarea {
    width: 100%; padding: .7rem 1rem; border: 1.5px solid var(--input-border); border-radius: 10px;
    font-family: 'Nunito', sans-serif; font-size: .92rem; background: var(--input-bg); outline: none; color: var(--input-color);
    transition: background .25s, border-color .25s, color .25s;
}
input:focus, select:focus, textarea:focus { border-color: #2563EB; background: var(--input-focus-bg); box-shadow: 0 0 0 3px rgba(37,99,235,.1); }
.btn-next {
    display: block; width: 100%; padding: .95rem; margin-top: 1.5rem;
    background: #2563EB; color: #fff; border: none; border-radius: 12px;
    font-family: 'Nunito', sans-serif; font-size: 1rem; font-weight: 800; cursor: pointer;
    transition: background .2s;
}
.btn-next:hover { background: #1D4ED8; }
.btn-back {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .5rem 1rem; border-radius: 10px; background: var(--btn-sec-bg);
    color: var(--btn-sec-txt); text-decoration: none; font-size: .88rem; font-weight: 700;
    border: none; cursor: pointer; font-family: 'Nunito', sans-serif;
    margin-bottom: 1rem; transition: background .15s;
}
.btn-back:hover { background: var(--btn-sec-hover); }
.option-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: .75rem; margin-bottom: .5rem; }
.option-btn {
    border: 2px solid var(--option-btn-bd); border-radius: 12px; background: var(--option-btn-bg); padding: .75rem;
    text-align: center; cursor: pointer; font-family: 'Nunito', sans-serif; font-size: .88rem;
    font-weight: 700; color: var(--option-btn-txt); transition: border-color .15s, background .15s, color .15s;
}
.option-btn:hover, .option-btn.selected { border-color: #2563EB; background: #EFF6FF; color: #2563EB; }
.option-btn input[type=radio] { display: none; }
.prod-summary {
    display: flex; align-items: center; gap: 1rem;
    background: var(--prod-sum-bg); border-radius: 14px; padding: 1rem 1.25rem; margin-bottom: 1.5rem;
    border: 1.5px solid var(--prod-sum-bd); transition: background .25s, border-color .25s;
}
.prod-summary-img { width: 56px; height: 56px; border-radius: 10px; background: var(--prod-img-bg); display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; transition: background .25s; }
.prod-summary-img img { width: 100%; height: 100%; object-fit: cover; }
.prod-summary-name { font-weight: 800; color: var(--heading-color); font-size: .95rem; }
.prod-summary-price { font-size: .88rem; color: #2563EB; font-weight: 700; }
</style>

<div class="ck-wrap">
    <!-- Stepper -->
    <div class="ck-steps">
        <?php for ($i = 0; $i < count($steps); $i++):
            $cls = $i+1 < $step ? 'done' : ($i+1 === $step ? 'active' : 'todo');
        ?>
            <?php if ($i > 0): ?><div class="ck-divider <?= $i < $step ? 'done':'' ?>"></div><?php endif; ?>
            <div class="ck-step <?= $cls ?>">
                <div class="ck-step-num"><?= $i+1 < $step ? '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" style="width: 14px; height: 14px;"><polyline points="20 6 9 17 4 12"/></svg>' : ($i+1) ?></div>
                <div class="ck-step-label"><?= $steps[$i] ?></div>
            </div>
        <?php endfor; ?>
    </div>

    <div class="ck-card">
        <?php if ($step > 1): ?>
            <button onclick="history.back()" class="btn-back">← Atrás</button>
        <?php endif; ?>
        <div class="ck-title"><?= $step_title ?></div>
        <?= $step_content ?>
    </div>
</div>
