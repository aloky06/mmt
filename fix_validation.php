<?php
$files = [
    'c:\booking-core.2.3.0\modules\Car\Views\frontend\listing\wizard.blade.php',
    'c:\booking-core.2.3.0\modules\Hotel\Views\frontend\listing\wizard.blade.php'
];

foreach ($files as $file) {
    if(!file_exists($file)) continue;
    $content = file_get_contents($file);

    // Use regex to inject validation check inside nextStep()
    // Find: function nextStep() { \s+ if (currentStep < totalSteps) {
    // Replace with: function nextStep() { \n if (!validateCurrentStep()) return; \n if (currentStep < totalSteps) {
    
    // First, check if it's already there
    if (strpos($content, '!validateCurrentStep()') !== false) {
        // Remove it if it is incorrectly placed somewhere else just in case, but it shouldn't be.
    }
    
    $content = preg_replace('/function\s+nextStep\(\)\s*\{\s*if\s*\(\s*currentStep\s*<\s*totalSteps\s*\)\s*\{/i', "function nextStep() {\n    if (!validateCurrentStep()) return;\n    if (currentStep < totalSteps) {", $content);

    // Also, make sure that goToStep(n) has the validation. 
    // It should have: if (n > currentStep && currentStep > 0 && !validateCurrentStep()) { return; }
    // Let's check if it has it.
    if (strpos($content, 'Prevent jumping forward') === false) {
        $goToStepRegex = '/if\(n === 0\.5\) \{[\s\S]*?return;\s*\}/i';
        $goToStepReplacement = "$0\n\n    // Prevent jumping forward via sidebar if current step is invalid\n    if (n > currentStep && currentStep > 0 && !validateCurrentStep()) {\n        return;\n    }\n";
        $content = preg_replace($goToStepRegex, $goToStepReplacement, $content, 1);
    }
    
    file_put_contents($file, $content);
    echo "Updated $file\n";
}
