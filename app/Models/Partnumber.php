<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partnumber extends Model
{
    use HasFactory;

    protected $table = 'partnumber';

    protected $fillable = [
        'item_id',
        'partnumber',
    ];

    public function lotnumbers()
    {
        return $this->hasMany(Lotnumber::class);
    }

    public function datastock(){
        return $this->hasMany(Datastock::class);
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
}
