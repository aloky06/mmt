<?php

namespace Modules\Flight\Models;

use App\BaseModel;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends BaseModel
{
    use SoftDeletes;
    
    protected $table = 'partners';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'referral_code',
        'commission_type',
        'commission_value',
        'payment_method',
        'payment_details',
        'status',
        'pan_number'
    ];

    protected $casts = [
        'payment_details' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function clicks()
    {
        return $this->hasMany(ReferralClick::class, 'partner_id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class, 'partner_id');
    }

    public function payoutRequests()
    {
        return $this->hasMany(PayoutRequest::class, 'partner_id');
    }

    public function bookings()
    {
        return $this->hasMany(\Modules\Booking\Models\Booking::class, 'partner_id');
    }
}
