<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTaskTracker extends Model
{
    use HasFactory;

    protected $table = 'vendors_tasks_tracker';

    protected $fillable = [
        'city_id',
        'vendor_id',
        'unit_id',
        'task_submission_date',
        'assigned_tasks',
        'any_scheduled_visits',
        'notes',
        'task_ending_date',
        'status',
        'urgent',
        'archived',
    ];

    protected $casts = [
        'task_submission_date' => 'date',
        'any_scheduled_visits' => 'date',
        'task_ending_date' => 'date',
        'archived' => 'boolean',
    ];

    // Relationships


    public function vendor()
    {
        return $this->belongsTo(VendorInfo::class, 'vendor_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
