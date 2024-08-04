<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manpower extends Model
{
    use HasFactory;

    protected $table = 'manpower';

    protected $fillable = [
        'name',
        'team_id',
        'noreg',
    ];

    public function team()
    {
        return $this->belongsTo(Teams::class);
    }
}
