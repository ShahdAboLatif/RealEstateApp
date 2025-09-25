<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class OffersAndRenewal extends Model
{
    use HasFactory;

    protected $table = 'offers_and_renewals';
    protected $appends = ['offer_status', 'renewal_status'];

    protected $fillable = [
        'unit_id',
        'date_sent_offer',
        'date_offer_expires',
        'status',
        'date_of_acceptance',
        'last_notice_sent',
        'how_many_days_left_offer',
        'notice_kind',
        'lease_sent',
        'date_sent_lease',
        'date_lease_expires',
        'lease_signed',
        'date_signed',
        'last_notice_sent_2',
        'notice_kind_2',
        'notes',
        'how_many_days_left_renewal',
        'expired',
        'archived',
    ];

    protected $casts = [
        'date_sent_offer' => 'date',
        'date_offer_expires' => 'date',
        'date_of_acceptance' => 'date',
        'last_notice_sent' => 'date',
        'date_sent_lease' => 'date',
        'date_lease_expires' => 'date',
        'date_signed' => 'date',
        'last_notice_sent_2' => 'date',
        'how_many_days_left' => 'integer',
        'archived' => 'boolean',
    ];

    // Relationships
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Calculate offer status based on status and expiration date
     */
    public function getOfferStatusAttribute(): string
    {
        if ($this->status === 'accepted') {
            return 'done';
        }

        if ($this->date_sent_offer && $this->how_many_days_left_offer) {
            $expirationDate = Carbon::parse($this->date_sent_offer)->addDays($this->how_many_days_left_offer);
            $today = Carbon::now()->startOfDay();

            return $today->gte($expirationDate) ? 'expired' : 'active';
        }

        return 'active';
    }

    /**
     * Calculate renewal status based on status and lease expiration date
     */
    public function getRenewalStatusAttribute(): string
    {
        if ($this->status === 'accepted') {
            if ($this->date_sent_lease && $this->how_many_days_left_renewal) {
            $expirationDate = Carbon::parse($this->date_sent_lease)->addDays($this->how_many_days_left_renewal);
            $today = Carbon::now()->startOfDay();

            return $today->gte($expirationDate) ? 'expired' : 'active';
        }
        return 'active';
        }

        return null;

    }
}
