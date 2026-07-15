<?php

namespace Modules\Flight\Models;

use App\BaseModel;

class ReferralClick extends BaseModel
{
    protected $table = 'referral_clicks';

    protected $fillable = [
        'partner_id',
        'landing_page',
        'ip_address',
        'user_agent',
        'session_token',
        'clicked_at'
    ];

    public $timestamps = true;

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }
}
