<?php
$files = [
    'c:\booking-core.2.3.0\modules\Car\Views\frontend\listing\wizard.blade.php',
    'c:\booking-core.2.3.0\modules\Hotel\Views\frontend\listing\wizard.blade.php'
];

$newCSS = <<<'CSS'
<style>
/* ===== Premium Wizard UI Overhaul ===== */
:root {
    --navy: #0f172a;
    --blue: #0A66C2; /* Modern vibrant blue */
    --blue-hover: #084e96;
    --blue-light: #eff6ff;
    --green: #10b981; /* Premium emerald green */
    --green-bg: #ecfdf5;
    --gold: #f59e0b;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-400: #94a3b8;
    --gray-600: #475569;
    --gray-800: #1e293b;
    --white: #ffffff;
    --red: #ef4444;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
}
*{box-sizing:border-box;margin:0;padding:0;}
body { font-family: 'Inter', 'Poppins', sans-serif; background: var(--gray-50); color: var(--gray-800); }

/* ---- TOP BAR ---- */
.wiz-topbar {
    background: var(--white); border-bottom: 1px solid var(--gray-200);
    padding: 0 40px; height: 64px;
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; z-index: 200;
    box-shadow: var(--shadow-sm);
}
.wiz-brand { font-size: 22px; font-weight: 800; color: var(--navy); text-decoration: none; letter-spacing: -0.5px; }
.wiz-brand span { color: var(--blue); }
.wiz-topbar-right { display: flex; align-items: center; gap: 20px; }
.wiz-topbar-right a { color: var(--gray-600); font-size: 14px; text-decoration: none; font-weight: 500; transition: color 0.2s; }
.wiz-topbar-right a:hover { color: var(--navy); }
.wiz-save-btn {
    background: var(--blue-light); color: var(--blue);
    border: 1.5px solid transparent; border-radius: 8px;
    padding: 8px 20px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s;
}
.wiz-save-btn:hover { background: var(--blue); color: var(--white); box-shadow: 0 4px 12px rgba(10,102,194,0.2); transform: translateY(-1px); }

/* ---- PROGRESS BAR ---- */
.wiz-progress-wrap {
    background: var(--white); border-bottom: 1px solid var(--gray-200);
    padding: 16px 40px;
    position: sticky; top: 64px; z-index: 199;
}
.wiz-progress-label {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 10px; font-size: 13px; color: var(--gray-600); font-weight: 500;
}
.wiz-progress-label strong { color: var(--navy); font-size: 14px; font-weight: 700; }
.wiz-progress-bar {
    height: 8px; background: var(--gray-200); border-radius: 4px; overflow: hidden;
}
.wiz-progress-fill {
    height: 100%; border-radius: 4px;
    background: linear-gradient(90deg, #2563eb, var(--blue));
    transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ---- MAIN LAYOUT ---- */
.wiz-layout {
    display: grid; grid-template-columns: 280px 1fr;
    min-height: calc(100vh - 140px);
    max-width: 1400px; margin: 0 auto;
}

/* ---- SIDEBAR ---- */
.wiz-sidebar {
    background: transparent;
    padding: 40px 20px 40px 0;
    position: sticky; top: 140px; height: calc(100vh - 140px);
    overflow-y: auto;
}
.wiz-sidebar::-webkit-scrollbar { width: 4px; }
.wiz-sidebar::-webkit-scrollbar-thumb { background: var(--gray-200); border-radius: 4px; }
.wiz-sidebar-group { margin-bottom: 28px; }
.wiz-sidebar-group-title {
    font-size: 11px; font-weight: 700; letter-spacing: 1px;
    color: var(--gray-400); text-transform: uppercase;
    padding: 0 24px; margin-bottom: 12px;
}
.wiz-sidebar-item {
    display: flex; align-items: center; gap: 14px;
    padding: 12px 24px; cursor: pointer;
    transition: all 0.2s; font-size: 14px; color: var(--gray-600); font-weight: 500;
    border-radius: 8px; margin-bottom: 4px;
}
.wiz-sidebar-item:hover { background: var(--gray-100); color: var(--navy); }
.wiz-sidebar-item.active {
    background: var(--white); color: var(--blue); font-weight: 600;
    box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200);
}
.wiz-sidebar-item.completed { color: var(--gray-800); }
.wiz-sidebar-item .item-icon {
    width: 24px; height: 24px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700; flex-shrink: 0;
    background: var(--gray-100); color: var(--gray-400);
    border: 1.5px solid var(--gray-200); transition: all 0.3s;
}
.wiz-sidebar-item.active .item-icon {
    background: var(--blue); color: var(--white); border-color: var(--blue);
    box-shadow: 0 0 0 4px var(--blue-light);
}
.wiz-sidebar-item.completed .item-icon {
    background: var(--green); color: var(--white); border-color: var(--green);
}

/* ---- CONTENT AREA ---- */
.wiz-content { padding: 40px; }
.wiz-step { display: none; }
.wiz-step.active { display: block; animation: stepFadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
@keyframes stepFadeIn { from{opacity:0; transform:translateY(15px);} to{opacity:1; transform:translateY(0);} }

.wiz-step-header { margin-bottom: 32px; }
.wiz-step-header h2 {
    font-size: clamp(26px, 3vw, 32px); font-weight: 800;
    color: var(--navy); line-height: 1.3; margin-bottom: 12px; letter-spacing: -0.5px;
}
.wiz-step-header p { font-size: 16px; color: var(--gray-600); line-height: 1.6; }

/* ---- CARDS ---- */
.wiz-card {
    background: var(--white); border: 1px solid var(--gray-200);
    border-radius: 12px; padding: 32px; margin-bottom: 24px;
    box-shadow: var(--shadow-md); transition: box-shadow 0.3s ease;
}
.wiz-card:hover { box-shadow: var(--shadow-lg); }
.wiz-card-title { font-size: 18px; font-weight: 700; color: var(--navy); margin-bottom: 24px; }

/* ---- FORM FIELDS ---- */
.wiz-row { display: flex; flex-wrap: wrap; margin: -12px; }
.wiz-col-12 { width: 100%; padding: 12px; }
.wiz-col-6 { width: 50%; padding: 12px; }
.wiz-col-4 { width: 33.333%; padding: 12px; }
@media(max-width: 768px) { .wiz-col-6, .wiz-col-4 { width: 100%; } }

.wiz-field { margin-bottom: 24px; }
.wiz-label {
    display: block; font-size: 14px; font-weight: 600; color: var(--navy);
    margin-bottom: 8px;
}
.wiz-input, .wiz-select, .wiz-textarea {
    width: 100%; padding: 12px 16px; font-size: 15px;
    border: 1.5px solid var(--gray-200); border-radius: 8px;
    background: var(--white); color: var(--gray-800);
    transition: all 0.2s; font-family: inherit;
}
.wiz-input::placeholder, .wiz-textarea::placeholder { color: var(--gray-400); }
.wiz-input:focus, .wiz-select:focus, .wiz-textarea:focus {
    border-color: var(--blue); outline: none;
    box-shadow: 0 0 0 4px rgba(10, 102, 194, 0.15);
}
.wiz-textarea { min-height: 120px; resize: vertical; }

/* ---- RADIO / CHECKBOX (Prop Type Cards) ---- */
.prop-type-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
.prop-type-card {
    border: 1.5px solid var(--gray-200); border-radius: 12px; padding: 20px;
    text-align: center; cursor: pointer; transition: all 0.2s; background: var(--white);
}
.prop-type-card:hover { border-color: var(--blue-hover); background: var(--blue-light); transform: translateY(-2px); }
.prop-type-card.selected {
    border-color: var(--blue); background: var(--blue-light);
    box-shadow: 0 0 0 1px var(--blue);
}
.prop-type-icon { font-size: 32px; color: var(--gray-600); margin-bottom: 12px; transition: color 0.2s; }
.prop-type-card:hover .prop-type-icon, .prop-type-card.selected .prop-type-icon { color: var(--blue); }
.prop-type-name { font-size: 15px; font-weight: 600; color: var(--navy); }
.prop-type-desc { font-size: 13px; color: var(--gray-600); margin-top: 6px; }

/* CHECKBOX LISTS */
.wiz-checkbox-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; }
.wiz-checkbox-item {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 16px; border: 1.5px solid var(--gray-200); border-radius: 8px;
    cursor: pointer; transition: all 0.2s; font-size: 14px; font-weight: 500; color: var(--gray-800);
}
.wiz-checkbox-item:hover { background: var(--gray-50); border-color: var(--gray-400); }
.wiz-checkbox-item input { width: 18px; height: 18px; accent-color: var(--blue); cursor: pointer; }
.wiz-checkbox-item:has(input:checked) { border-color: var(--blue); background: var(--blue-light); }

/* LOCATION SELECTOR */
.loc-list { border: 1.5px solid var(--gray-200); border-radius: 8px; max-height: 250px; overflow-y: auto; }
.loc-item { padding: 12px 16px; border-bottom: 1px solid var(--gray-200); display: flex; align-items: center; gap: 12px; cursor: pointer; font-size: 14px; font-weight: 500;}
.loc-item:last-child { border-bottom: none; }
.loc-item:hover { background: var(--gray-50); }
.loc-item input { width: 18px; height: 18px; accent-color: var(--blue); }

/* ---- NAV BUTTONS ---- */
.wiz-nav {
    display: flex; justify-content: space-between; align-items: center;
    margin-top: 40px; padding-top: 24px; border-top: 1px solid var(--gray-200);
}
.wiz-btn {
    padding: 12px 28px; border-radius: 8px; font-size: 15px; font-weight: 600;
    cursor: pointer; transition: all 0.2s; border: none; outline: none;
    display: inline-flex; align-items: center; gap: 8px;
}
.wiz-btn-back { background: var(--white); color: var(--gray-800); border: 1.5px solid var(--gray-200); }
.wiz-btn-back:hover { background: var(--gray-100); border-color: var(--gray-400); }
.wiz-btn-next, .wiz-btn-submit {
    background: var(--blue); color: var(--white);
    box-shadow: 0 4px 12px rgba(10, 102, 194, 0.2);
}
.wiz-btn-next:hover, .wiz-btn-submit:hover {
    background: var(--blue-hover); transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(10, 102, 194, 0.3);
}
.wiz-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; box-shadow: none; }

/* SUMMARY (Review Step) */
.wiz-summary-section { margin-bottom: 32px; }
.wiz-summary-title { font-size: 16px; font-weight: 700; color: var(--navy); border-bottom: 1.5px solid var(--gray-200); padding-bottom: 12px; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px; }
.wiz-summary-row { display: flex; padding: 10px 0; border-bottom: 1px dashed var(--gray-200); font-size: 14px; }
.wiz-summary-row .sk { width: 40%; color: var(--gray-600); font-weight: 500; }
.wiz-summary-row .sv { width: 60%; color: var(--gray-800); font-weight: 600; }

@media(max-width: 992px) {
    .wiz-layout { grid-template-columns: 1fr; }
    .wiz-sidebar { display: none; } /* Hide sidebar on small mobile, rely on top progress bar */
    .wiz-content { padding: 24px 16px; }
    .wiz-topbar { padding: 0 16px; }
}
</style>
CSS;

$jsOldGoToStep = <<<'JS'
    document.querySelectorAll('.wiz-sidebar-item').forEach(el => {
        const s = parseInt(el.getAttribute('data-step'));
        el.classList.remove('active');
        if (s < n) el.classList.add('completed');
        else el.classList.remove('completed');
    });
JS;

$jsNewGoToStep = <<<'JS'
    document.querySelectorAll('.wiz-sidebar-item').forEach(el => {
        const s = parseInt(el.getAttribute('data-step'));
        let iconSpan = el.querySelector('.item-icon');
        el.classList.remove('active');
        if (s < n) {
            el.classList.add('completed');
            if(iconSpan) iconSpan.innerHTML = '<i class="fa fa-check"></i>';
        } else {
            el.classList.remove('completed');
            if(iconSpan) iconSpan.innerHTML = s;
        }
    });
JS;

foreach ($files as $file) {
    if(!file_exists($file)) continue;
    $content = file_get_contents($file);

    // Replace <style> block
    // We will extract everything between <style> and </style> and replace it.
    $content = preg_replace('/<style>[\s\S]*?<\/style>/', $newCSS, $content);

    // Replace goToStep sidebar logic to add checkmarks
    $content = str_replace($jsOldGoToStep, $jsNewGoToStep, $content);
    
    file_put_contents($file, $content);
    echo "Updated $file\n";
}
