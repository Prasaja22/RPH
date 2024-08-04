<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datastock extends Model
{
    use HasFactory;

    protected $table = 'datastock';

    protected $fillable = [
        'partnumber_id',
        'date',
        'stock',
    ];

    public function partnumber()
    {
        return $this->belongsTo(Partnumber::class);
    }

}
