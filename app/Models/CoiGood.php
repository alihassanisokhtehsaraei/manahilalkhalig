<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoiGood extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'order_id',
        'coi_id',
        'certType',
        'quantity',
        'packing',
        'desc',
        'netWeight',
        'grossWeight',
        'HSCode',
        'standards',
        'size',
        'user_id',
        'ip'
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function coi()
    {
        return $this->belongsTo(Coi::class, 'coi_id', 'id');
    }
}
