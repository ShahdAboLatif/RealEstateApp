<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $table = 'notices';

    protected $fillable = [
        'name',
        'days',
    ];

    protected $casts = [
        'days' => 'integer',
    ];

    // Relationships
    public function noticeAndEvictions()
    {
        return $this->hasMany(NoticeAndEviction::class);
    }
}
