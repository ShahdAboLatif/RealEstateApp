<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoveOut extends Model
{
    use HasFactory;

    protected $table = 'move_outs';

    protected $fillable = [
        'unit_id',
        'move_out_date',
        'lease_status',
        'date_lease_ending_on_buildium',
        'keys_location',
        'utilities_under_our_name',
        'date_utility_put_under_our_name',
        'walkthrough',
        'repairs',
        'send_back_security_deposit',
        'notes',
        'cleaning',
        'list_the_unit',
        'move_out_form',
        'archived',
    ];

    protected $casts = [
        'move_out_date' => 'date',
        'date_lease_ending_on_buildium' => 'date',
        'date_utility_put_under_our_name' => 'date',
        'utilities_under_our_name' => 'boolean',
        'walkthrough' => 'boolean',
        'repairs' => 'boolean',
        'send_back_security_deposit' => 'boolean',
        'cleaning' => 'boolean',
        'list_the_unit' => 'boolean',
        'move_out_form' => 'boolean',
        'archived' => 'boolean',
    ];

    // Relationship with Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
