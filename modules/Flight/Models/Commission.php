<?php

namespace Modules\Flight\Models;

use App\BaseModel;
use Modules\Booking\Models\Booking;

class Commission extends BaseModel
{
    protected $table = 'commissions';

    protected $fillable = [
        'partner_id',
        'booking_id',
        'booking_amount',
        'commission_amount',
        'status',
        'confirmed_at',
        'paid_at'
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'paid_at' => 'datetime'
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}
