<?php
try { 
    $booking = \Modules\Booking\Models\Booking::find(21); 
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('Booking::emails.invoice-pdf', ['booking' => $booking, 'service' => $booking->service, 'to' => 'customer']); 
    $pdf->output(); 
    echo 'SUCCESS'; 
} catch(\Exception $e) { 
    echo 'ERROR: ' . $e->getMessage(); 
}
