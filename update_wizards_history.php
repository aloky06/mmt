<?php
$files = [
    'c:\booking-core.2.3.0\modules\Car\Views\frontend\listing\wizard.blade.php',
    'c:\booking-core.2.3.0\modules\Hotel\Views\frontend\listing\wizard.blade.php'
];

$jsHistoryExtension = <<<'JS'
<script>
// Prevent data loss when using browser Back/Forward buttons
document.addEventListener('DOMContentLoaded', function() {
    // Push initial state
    if (!window.history.state) {
        window.history.replaceState({ step: 1 }, "Step 1", "#step1");
    }

    // Intercept back/forward buttons
    window.addEventListener('popstate', function(e) {
        if (e.state && e.state.step) {
            // We skip validation on popstate because user is just navigating history
            executeGoToStep(e.state.step);
        }
    });
});

// We need to modify goToStep to push history state
// Let's hook into goToStep
const originalGoToStep = window.goToStep;
window.goToStep = function(n) {
    // Do the validation check for forward jumps first
    if (n > currentStep && currentStep > 0 && typeof validateCurrentStep === 'function' && !validateCurrentStep()) {
        return;
    }
    
    // Push state
    if (n >= 1) {
        window.history.pushState({ step: n }, "Step " + n, "#step" + n);
    }
    
    executeGoToStep(n);
};

function executeGoToStep(n) {
    if(n === 0) {
        document.querySelectorAll('.wiz-step').forEach(e => e.classList.remove('active'));
        document.getElementById('step0').classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
    }
    if(n === 0.5) {
        document.querySelectorAll('.wiz-step').forEach(e => e.classList.remove('active'));
        document.getElementById('step05').classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
    }
    
    document.getElementById('step' + currentStep).classList.remove('active');
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
    currentStep = n;
    const el = document.getElementById('step' + n);
    if (el) el.classList.add('active');
    let sidebarItem = document.querySelector('[data-step="' + n + '"]');
    if (sidebarItem) sidebarItem.classList.add('active');
    
    const pct = Math.round((n / totalSteps) * 100);
    let fill = document.getElementById('progressFill');
    if (fill) fill.style.width = pct + '%';
    let pctEl = document.getElementById('stepPercent');
    if (pctEl) pctEl.textContent = pct + '%';
    let titleEl = document.getElementById('stepTitle');
    if (titleEl && typeof stepTitles !== 'undefined') titleEl.textContent = stepTitles[n];
    
    let progressWrap = document.querySelector('.wiz-progress-wrap');
    if (progressWrap) {
        let topPos = progressWrap.getBoundingClientRect().top + window.scrollY - 60;
        window.scrollTo({ top: topPos, behavior: 'smooth' });
    } else {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}
</script>
</body>
JS;

foreach ($files as $file) {
    if(!file_exists($file)) continue;
    $content = file_get_contents($file);

    // We need to completely REPLACE the existing goToStep function in the file to avoid conflicts.
    // The existing goToStep function is quite long, so we'll use regex to remove it.
    $goToStepRegex = '/function\s+goToStep\s*\(\s*n\s*\)\s*\{[\s\S]*?window\.scrollTo\(\{[\s\S]*?\}\s*\}\s*\}/i';
    
    // First, let's just test if we can find it
    if (preg_match($goToStepRegex, $content)) {
        // Remove the original goToStep function since we redefine it in our extension script
        $content = preg_replace($goToStepRegex, '', $content);
    }
    
    // Add the new script before </body>
    if (strpos($content, 'popstate') === false) {
        $content = str_replace('</body>', $jsHistoryExtension, $content);
    }
    
    file_put_contents($file, $content);
    echo "Updated $file\n";
}
