<?php
$files = [
    'c:\booking-core.2.3.0\modules\Car\Views\frontend\listing\wizard.blade.php',
    'c:\booking-core.2.3.0\modules\Hotel\Views\frontend\listing\wizard.blade.php'
];

$jsValidationFunc = <<<'JS'
function validateCurrentStep() {
    let currentDiv = document.getElementById('step' + currentStep);
    if (!currentDiv) return true;
    
    let isValid = true;
    let firstInvalid = null;
    
    let requiredFields = currentDiv.querySelectorAll('input[required], textarea[required], select[required]');
    
    requiredFields.forEach(field => {
        // Don't validate if field is disabled
        if (field.disabled) return;
        
        if (!field.checkValidity()) {
            isValid = false;
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
            if (!firstInvalid) firstInvalid = field;
        } else {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        }
    });
    
    if (!isValid && firstInvalid) {
        showInlineMsg('step' + currentStep, 'Please fill in all required fields correctly before proceeding.', true);
        firstInvalid.focus();
        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } else {
        let msgDiv = currentDiv.querySelector('.wiz-inline-msg');
        if (msgDiv) msgDiv.style.display = 'none';
    }
    
    return isValid;
}

function nextStep() {
JS;

foreach ($files as $file) {
    if(!file_exists($file)) continue;
    $content = file_get_contents($file);

    // 1. Inject validateCurrentStep() right above nextStep()
    // We'll replace "function nextStep() {" with the new function + "function nextStep() {"
    // But check if it already exists to avoid duplicate
    if (strpos($content, 'function validateCurrentStep()') === false) {
        $content = str_replace('function nextStep() {', $jsValidationFunc, $content);
    }

    // 2. Add validation check inside nextStep()
    $oldNextStep = <<<'JS'
function nextStep() {
    if (currentStep < totalSteps) {
JS;
    $newNextStep = <<<'JS'
function nextStep() {
    if (!validateCurrentStep()) return;
    if (currentStep < totalSteps) {
JS;
    $content = str_replace($oldNextStep, $newNextStep, $content);

    // 3. Add validation check to goToStep for forward jumping via sidebar
    $oldGoToStep = <<<'JS'
    if(n === 0.5) {
        document.querySelectorAll('.wiz-step').forEach(e => e.classList.remove('active'));
        document.getElementById('step05').classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
    }
    document.getElementById('step' + currentStep).classList.remove('active');
JS;
    $newGoToStep = <<<'JS'
    if(n === 0.5) {
        document.querySelectorAll('.wiz-step').forEach(e => e.classList.remove('active'));
        document.getElementById('step05').classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
        return;
    }
    
    // Prevent jumping forward via sidebar if current step is invalid
    if (n > currentStep && currentStep > 0 && !validateCurrentStep()) {
        return;
    }
    
    document.getElementById('step' + currentStep).classList.remove('active');
JS;
    $content = str_replace($oldGoToStep, $newGoToStep, $content);
    
    file_put_contents($file, $content);
    echo "Updated $file\n";
}
