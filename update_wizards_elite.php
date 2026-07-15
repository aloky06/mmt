<?php
$files = [
    'c:\booking-core.2.3.0\modules\Car\Views\frontend\listing\wizard.blade.php',
    'c:\booking-core.2.3.0\modules\Hotel\Views\frontend\listing\wizard.blade.php'
];

$newCSS = <<<'CSS'
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

/* ===== Elite Wizard UI Overhaul ===== */
:root {
    --navy: #0f172a;
    --blue: #3b82f6; /* Brilliant Blue */
    --blue-hover: #2563eb;
    --blue-light: #eff6ff;
    --green: #10b981; /* Emerald */
    --green-bg: #ecfdf5;
    --gold: #f59e0b;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-600: #475569;
    --gray-800: #1e293b;
    --white: #ffffff;
    --red: #ef4444;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --focus-ring: 0 0 0 4px rgba(59, 130, 246, 0.2);
}
*{box-sizing:border-box;margin:0;padding:0;}
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--gray-50); color: var(--gray-800); -webkit-font-smoothing: antialiased; }

/* ---- TOP BAR ---- */
.wiz-topbar {
    background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--gray-200); padding: 0 40px; height: 72px;
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; z-index: 200; box-shadow: var(--shadow-sm);
}
.wiz-brand { font-size: 24px; font-weight: 800; color: var(--navy); text-decoration: none; letter-spacing: -0.5px; }
.wiz-brand span { color: var(--blue); }
.wiz-topbar-right { display: flex; align-items: center; gap: 24px; }
.wiz-topbar-right a { color: var(--gray-600); font-size: 14px; text-decoration: none; font-weight: 600; transition: color 0.2s; }
.wiz-topbar-right a:hover { color: var(--navy); }
.wiz-save-btn {
    background: var(--blue-light); color: var(--blue);
    border: none; border-radius: 10px;
    padding: 10px 24px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.wiz-save-btn:hover { background: var(--blue); color: var(--white); box-shadow: 0 8px 16px rgba(59,130,246,0.25); transform: translateY(-2px); }

/* ---- PROGRESS BAR ---- */
.wiz-progress-wrap {
    background: var(--white); border-bottom: 1px solid var(--gray-200);
    padding: 16px 40px; position: sticky; top: 72px; z-index: 199;
}
.wiz-progress-label {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 10px; font-size: 13px; color: var(--gray-600); font-weight: 600;
}
.wiz-progress-label strong { color: var(--navy); font-size: 14px; font-weight: 800; letter-spacing: -0.2px; }
.wiz-progress-bar { height: 8px; background: var(--gray-100); border-radius: 4px; overflow: hidden; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05); }
.wiz-progress-fill {
    height: 100%; border-radius: 4px;
    background: linear-gradient(90deg, #1d4ed8, var(--blue));
    transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

/* ---- MAIN LAYOUT ---- */
.wiz-layout {
    display: grid; grid-template-columns: 300px 1fr;
    min-height: calc(100vh - 150px); max-width: 1400px; margin: 0 auto; gap: 40px;
}

/* ---- TIMELINE SIDEBAR ---- */
.wiz-sidebar {
    background: transparent; padding: 40px 10px 40px 0;
    position: sticky; top: 150px; height: calc(100vh - 150px); overflow-y: auto;
}
.wiz-sidebar::-webkit-scrollbar { width: 4px; }
.wiz-sidebar::-webkit-scrollbar-thumb { background: var(--gray-200); border-radius: 4px; }
.wiz-sidebar-group { margin-bottom: 32px; }
.wiz-sidebar-group-title {
    font-size: 11px; font-weight: 800; letter-spacing: 1.5px;
    color: var(--gray-400); text-transform: uppercase;
    padding: 0 24px; margin-bottom: 16px;
}
.wiz-sidebar-item {
    position: relative; display: flex; align-items: center; gap: 16px;
    padding: 14px 24px; cursor: pointer;
    transition: all 0.3s ease; font-size: 14px; color: var(--gray-600); font-weight: 600;
    border-radius: 12px; margin-bottom: 8px; z-index: 2;
}
/* Timeline Connectors */
.wiz-sidebar-item:not(:last-child)::after {
    content: ''; position: absolute;
    left: 37px; top: 40px; bottom: -8px; width: 2px;
    background: var(--gray-200); z-index: -1;
    transition: background 0.4s ease;
}
.wiz-sidebar-item.completed:not(:last-child)::after { background: var(--blue); }

.wiz-sidebar-item:hover { background: rgba(241, 245, 249, 0.5); color: var(--navy); }
.wiz-sidebar-item.active {
    background: var(--white); color: var(--blue); font-weight: 700;
    box-shadow: var(--shadow-md); transform: scale(1.02);
}
.wiz-sidebar-item.completed { color: var(--gray-800); }
.wiz-sidebar-item .item-icon {
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800; flex-shrink: 0;
    background: var(--white); color: var(--gray-400);
    border: 2px solid var(--gray-200); transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.wiz-sidebar-item.active .item-icon {
    background: var(--blue); color: var(--white); border-color: var(--blue);
    box-shadow: 0 0 0 4px var(--blue-light);
}
.wiz-sidebar-item.completed .item-icon {
    background: var(--green); color: var(--white); border-color: var(--green);
    animation: popIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
@keyframes popIn { 0%{transform:scale(0.8);} 50%{transform:scale(1.1);} 100%{transform:scale(1);} }

/* ---- CONTENT AREA & ANIMATIONS ---- */
.wiz-content { padding: 40px 0; }
.wiz-step { display: none; }
.wiz-step.active { display: block; animation: stepFadeSlide 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
@keyframes stepFadeSlide { from{opacity:0; transform:translateY(20px);} to{opacity:1; transform:translateY(0);} }

.wiz-step-header { margin-bottom: 40px; }
.wiz-step-header h2 {
    font-size: clamp(28px, 4vw, 36px); font-weight: 800;
    color: var(--navy); line-height: 1.2; margin-bottom: 12px; letter-spacing: -1px;
}
.wiz-step-header p { font-size: 16px; color: var(--gray-600); line-height: 1.6; font-weight: 500; }

/* ---- PREMIUM CARDS ---- */
.wiz-card {
    background: var(--white); border: 1px solid rgba(226, 232, 240, 0.8);
    border-radius: 16px; padding: 40px; margin-bottom: 24px;
    box-shadow: var(--shadow-sm); transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.wiz-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-2px); border-color: var(--gray-300); }
.wiz-card-title { font-size: 18px; font-weight: 800; color: var(--navy); margin-bottom: 24px; letter-spacing: -0.3px; }

/* ---- FORM FIELDS (GLASSMORPHISM FOCUS) ---- */
.wiz-row { display: flex; flex-wrap: wrap; margin: -12px; }
.wiz-col-12 { width: 100%; padding: 12px; }
.wiz-col-6 { width: 50%; padding: 12px; }
.wiz-col-4 { width: 33.333%; padding: 12px; }
@media(max-width: 768px) { .wiz-col-6, .wiz-col-4 { width: 100%; } }

.wiz-field { margin-bottom: 28px; }
.wiz-label {
    display: block; font-size: 13px; font-weight: 700; color: var(--gray-600);
    margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px;
}
.wiz-input, .wiz-select, .wiz-textarea {
    width: 100%; padding: 14px 18px; font-size: 15px; font-weight: 500;
    border: 1.5px solid var(--gray-200); border-radius: 10px;
    background: var(--gray-50); color: var(--gray-800);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); font-family: inherit;
    box-shadow: inset 0 1px 2px rgba(0,0,0,0.02);
}
.wiz-input::placeholder, .wiz-textarea::placeholder { color: var(--gray-400); font-weight: 400; }
.wiz-input:focus, .wiz-select:focus, .wiz-textarea:focus {
    border-color: var(--blue); outline: none; background: var(--white);
    box-shadow: var(--focus-ring), 0 4px 12px rgba(0,0,0,0.03);
}
.wiz-textarea { min-height: 140px; resize: vertical; }

/* ---- CUSTOM COMPONENT STYLING (RADIO/CHECKBOX GRIDS) ---- */
.prop-type-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; }
.prop-type-card {
    border: 1.5px solid var(--gray-200); border-radius: 16px; padding: 24px;
    text-align: center; cursor: pointer; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); background: var(--white);
}
.prop-type-card:hover { border-color: var(--blue-hover); box-shadow: var(--shadow-md); transform: translateY(-4px); }
.prop-type-card.selected {
    border-color: var(--blue); background: var(--blue-light);
    box-shadow: 0 0 0 2px var(--blue); transform: translateY(-2px);
}
.prop-type-icon { font-size: 36px; color: var(--gray-400); margin-bottom: 16px; transition: all 0.3s; }
.prop-type-card:hover .prop-type-icon { color: var(--blue-hover); transform: scale(1.1); }
.prop-type-card.selected .prop-type-icon { color: var(--blue); transform: scale(1.1); }
.prop-type-name { font-size: 16px; font-weight: 700; color: var(--navy); letter-spacing: -0.3px; }
.prop-type-desc { font-size: 13px; color: var(--gray-600); margin-top: 8px; font-weight: 500; }

/* CUSTOM CHECKBOX LISTS */
.wiz-checkbox-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 16px; }
.wiz-checkbox-item {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 18px; border: 1.5px solid var(--gray-200); border-radius: 12px;
    cursor: pointer; transition: all 0.3s; font-size: 15px; font-weight: 600; color: var(--gray-800);
    background: var(--white);
}
.wiz-checkbox-item:hover { background: var(--gray-50); border-color: var(--gray-300); transform: translateY(-1px); box-shadow: var(--shadow-sm); }
.wiz-checkbox-item input { width: 20px; height: 20px; accent-color: var(--blue); cursor: pointer; }
.wiz-checkbox-item:has(input:checked) { border-color: var(--blue); background: var(--blue-light); box-shadow: 0 0 0 1px var(--blue); }

/* LOCATION SELECTOR */
.loc-list { border: 1.5px solid var(--gray-200); border-radius: 12px; max-height: 280px; overflow-y: auto; background: var(--white); }
.loc-list::-webkit-scrollbar { width: 6px; }
.loc-list::-webkit-scrollbar-thumb { background: var(--gray-300); border-radius: 6px; }
.loc-item { padding: 14px 20px; border-bottom: 1px solid var(--gray-100); display: flex; align-items: center; gap: 14px; cursor: pointer; font-size: 15px; font-weight: 600; transition: background 0.2s;}
.loc-item:last-child { border-bottom: none; }
.loc-item:hover { background: var(--blue-light); color: var(--blue); }
.loc-item input { width: 20px; height: 20px; accent-color: var(--blue); }

/* ---- NAV BUTTONS ---- */
.wiz-nav {
    display: flex; justify-content: space-between; align-items: center;
    margin-top: 40px; padding-top: 32px; border-top: 1px solid var(--gray-200);
}
.wiz-btn {
    padding: 14px 32px; border-radius: 10px; font-size: 15px; font-weight: 700; letter-spacing: 0.3px;
    cursor: pointer; transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); border: none; outline: none;
    display: inline-flex; align-items: center; gap: 10px; justify-content: center;
}
.wiz-btn-back { background: var(--white); color: var(--gray-600); border: 1.5px solid var(--gray-200); }
.wiz-btn-back:hover { background: var(--gray-50); color: var(--navy); border-color: var(--gray-300); transform: translateX(-2px); }
.wiz-btn-next, .wiz-btn-submit {
    background: linear-gradient(135deg, var(--blue), #2563eb); color: var(--white);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}
.wiz-btn-next:hover, .wiz-btn-submit:hover {
    background: linear-gradient(135deg, var(--blue-hover), #1d4ed8);
    transform: translateY(-2px); box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
}
.wiz-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; box-shadow: none; filter: grayscale(1); }

/* SUMMARY (Review Step) */
.wiz-summary-section { margin-bottom: 40px; }
.wiz-summary-title { font-size: 14px; font-weight: 800; color: var(--gray-400); border-bottom: 1.5px solid var(--gray-100); padding-bottom: 16px; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1.5px; }
.wiz-summary-row { display: flex; padding: 14px 0; border-bottom: 1px dashed var(--gray-200); font-size: 15px; transition: background 0.2s; border-radius: 8px; }
.wiz-summary-row:hover { background: var(--gray-50); padding-left: 12px; padding-right: 12px; }
.wiz-summary-row .sk { width: 40%; color: var(--gray-500); font-weight: 600; }
.wiz-summary-row .sv { width: 60%; color: var(--navy); font-weight: 700; }

@media(max-width: 992px) {
    .wiz-layout { grid-template-columns: 1fr; gap: 20px; }
    .wiz-sidebar { display: none; }
    .wiz-content { padding: 24px 16px; }
    .wiz-topbar { padding: 0 20px; height: 60px; }
    .wiz-progress-wrap { padding: 12px 20px; top: 60px; }
}
</style>
CSS;

foreach ($files as $file) {
    if(!file_exists($file)) continue;
    $content = file_get_contents($file);

    // Replace the entire <style> block
    $content = preg_replace('/<style>[\s\S]*?<\/style>/', $newCSS, $content);
    
    file_put_contents($file, $content);
    echo "Updated $file\n";
}
