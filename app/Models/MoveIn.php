<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoveIn extends Model
{
    use HasFactory;

    protected $table = 'move_ins';

    protected $fillable = [
        'unit_id',
        'signed_lease',
        'lease_signing_date',
        'lease_status',
        'lease_start',
        'lease_end',
        'move_in_form_sent_date',
        'filled_move_in_form',
        'date_of_move_in_form_filled',
        'handled_keys',
        'move_in_date',
        'Has_paid_security_deposit_first_month_rent',
        'note_paid_security_deposit_first_month_rent',
        'scheduled_paid_time',
        'has_assistance',
        'assistance_amount',
        'assistance_company',
        'has_insurance',
        'insurance_status',
        'submitted_insurance',
        'date_of_insurance_expiration',
        'cash_or_check',
        'permanent',
        'archived',
    ];

    protected $casts = [
        'lease_signing_date' => 'date',
        'lease_start' => 'date',
        'lease_end' => 'date',
        'move_in_form_sent_date' => 'date',
        'date_of_move_in_form_filled' => 'date',
        'move_in_date' => 'date',
        'scheduled_paid_time' => 'date',
        'date_of_insurance_expiration' => 'date',
        'assistance_amount' => 'decimal:2',
        'signed_lease' => 'boolean',
        'filled_move_in_form' => 'boolean',
        'handled_keys' => 'boolean',
        'Has_paid_security_deposit_first_month_rent' => 'boolean',
        'has_assistance' => 'boolean',
        'has_insurance' => 'boolean',
        'submitted_insurance' => 'boolean',
        'permanent' => 'boolean',
        'archived' => 'boolean',
    ];

    // Relationship with Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
