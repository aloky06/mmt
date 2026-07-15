<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try { 
    $booking = \Modules\Booking\Models\Booking::find(21); 
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('Booking::emails.invoice-pdf', ['booking' => $booking, 'service' => $booking->service, 'to' => 'customer']); 
    $pdf->output(); 
    echo 'SUCCESS'; 
} catch(\Exception $e) { 
    echo 'ERROR: ' . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine(); 
}
