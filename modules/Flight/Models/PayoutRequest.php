<?php

namespace Modules\Flight\Models;

use App\BaseModel;

class PayoutRequest extends BaseModel
{
    protected $table = 'payout_requests';

    protected $fillable = [
        'partner_id',
        'amount',
        'status',
        'requested_at',
        'processed_at'
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'processed_at' => 'datetime'
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }
}
