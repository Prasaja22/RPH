<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id', 'partnumber', 'team', 'plan', 'lot_no', 'qty',
        'target_perjam_1', 'target_perjam_2', 'act', 'status'
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
