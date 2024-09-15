<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'fullName',
        'cName',
        'email',
        'tel',
        'mobile',
        'country',
        'stateCity',
        'address',
        'creator',
        'branch',
        'ip',
    ];

    public function GlobalCounter()
    {
        return $this->hasMany(GlobalCounter::class);
    }

    public function Order()
    {
        return $this->hasMany(Order::class);
    }


    public function User()
    {
        return $this->belongsTo(User::class);

    }

}
