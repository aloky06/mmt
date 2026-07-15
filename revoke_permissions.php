<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$role = Spatie\Permission\Models\Role::findByName('vendor');
$role->revokePermissionTo([
    'hotel_view', 'hotel_create', 'hotel_update', 'hotel_delete',
    'car_view', 'car_create', 'car_update', 'car_delete',
    'tour_view', 'tour_create', 'tour_update', 'tour_delete',
    'space_view', 'space_create', 'space_update', 'space_delete',
    'flight_view', 'flight_create', 'flight_update', 'flight_delete',
    'event_view', 'event_create', 'event_update', 'event_delete'
]);
echo "Permissions revoked.\n";
