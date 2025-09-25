<?php
// app/Models/Application.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'name',
        'co_signer',
        'status',
        'date',
        'stage_in_progress',
        'notes',
        'attachment_name',
        'attachment_path',
        'archived',
    ];

    protected $casts = [
        'date' => 'date',
        'archived' => 'boolean',
    ];

    // Relationships
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // Accessor for formatted date
    public function getFormattedDateAttribute(): ?string
    {
        if ($this->date instanceof Carbon) {
            return $this->date->format('M d, Y');
        }

        return null;
    }

    // Scope for filtering by status
    public function scopeByStatus($query, $status)
    {
        return $status ? $query->where('status', $status) : $query;
    }

    // Scope for filtering by stage
    public function scopeByStage($query, $stage)
    {
        return $stage ? $query->where('stage_in_progress', $stage) : $query;
    }

    // Scope for filtering by unit
    public function scopeByUnit($query, $unitId)
    {
        return $unitId ? $query->where('unit_id', $unitId) : $query;
    }

    // Get status color for UI
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'approved' => 'green',
            'rejected' => 'red',
            'in_review' => 'yellow',
            'pending' => 'blue',
            default => 'gray'
        };
    }
}
