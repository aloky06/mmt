<?php
$files = [
    'c:\booking-core.2.3.0\modules\Car\Views\frontend\listing\wizard.blade.php',
    'c:\booking-core.2.3.0\modules\Hotel\Views\frontend\listing\wizard.blade.php'
];

foreach ($files as $file) {
    if(!file_exists($file)) continue;
    $content = file_get_contents($file);

    // Replace window.scrollTo({ top: 0, behavior: 'smooth' });
    // with a scroll to the progress wrap so it doesn't jump to the very top of the page.
    $oldScroll = "window.scrollTo({ top: 0, behavior: 'smooth' });";
    $newScroll = <<<'JS'
    let progressWrap = document.querySelector('.wiz-progress-wrap');
    if (progressWrap) {
        let topPos = progressWrap.getBoundingClientRect().top + window.scrollY - 60;
        window.scrollTo({ top: topPos, behavior: 'smooth' });
    } else {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
JS;

    $content = str_replace($oldScroll, $newScroll, $content);
    
    // Also let's fix the step 0 / 0.5 scrolling if they don't have it
    $goToStepFix0 = <<<'JS'
    if(n === 0) {
        document.querySelectorAll('.wiz-step').forEach(e => e.classList.remove('active'));
        document.getElementById('step0').classList.add('active');
JS;
    $goToStepFixNew0 = <<<'JS'
    if(n === 0) {
        document.querySelectorAll('.wiz-step').forEach(e => e.classList.remove('active'));
        document.getElementById('step0').classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
JS;
    $content = str_replace($goToStepFix0, $goToStepFixNew0, $content);

    $goToStepFix05 = <<<'JS'
    if(n === 0.5) {
        document.querySelectorAll('.wiz-step').forEach(e => e.classList.remove('active'));
        document.getElementById('step05').classList.add('active');
JS;
    $goToStepFixNew05 = <<<'JS'
    if(n === 0.5) {
        document.querySelectorAll('.wiz-step').forEach(e => e.classList.remove('active'));
        document.getElementById('step05').classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
JS;
    $content = str_replace($goToStepFix05, $goToStepFixNew05, $content);

    file_put_contents($file, $content);
    echo "Updated $file\n";
}
