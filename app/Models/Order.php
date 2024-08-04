<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';

    protected $fillable = [
        'itemid',
        'customer',
        'date',
        'jumlah_order',
    ];

    public function partnumber()
    {
        return $this->belongsTo(Partnumber::class, 'itemid'); // 'itemid' adalah nama foreign key
    }

}
