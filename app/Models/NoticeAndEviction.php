<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notice;
use Illuminate\Support\Carbon;
class NoticeAndEviction extends Model
{
    use HasFactory;

    protected $table = 'notice_and_evictions';

    protected $appends = ['evictions'];

    protected $fillable = [
        'unit_id',
        'notice_id',
        'status',
        'date',
        'have_an_exception',
        'note',

        'sent_to_attorney',
        'hearing_dates',
        'evicted_or_payment_plan',
        'if_left',
        'writ_date',
        'archived',
    ];

    protected $casts = [
        'date' => 'date',
        'hearing_dates' => 'date',
        'writ_date' => 'date',
        'archived' => 'boolean',
    ];

    // Relationships
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function notice()
    {
        return $this->belongsTo(Notice::class);
    }

    public function getEvictionsAttribute(){
        if($this->have_an_exception ){
            return 'has an exception';
        }
        else{
            $daysLeft= $this->notice()->value('days') ?? 0;
            $expirationDate = Carbon::parse($this->date)->addDays($daysLeft);
            $today = Carbon::now()->startOfDay();
            return $today->gte($expirationDate) ? 'evicted' : '-';
        }

    }
}
