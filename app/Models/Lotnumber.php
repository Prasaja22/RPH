<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lotnumber extends Model
{
    use HasFactory;

    protected $table = 'lotnumber';

    protected $fillable = [
        'partnumber_id',
        'lotnumber',
        'qty',
    ];

    public function partnumber()
    {
        return $this->belongsTo(Partnumber::class);
    }
}
