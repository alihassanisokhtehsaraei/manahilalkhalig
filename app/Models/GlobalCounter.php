<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GlobalCounter extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'trackingID',
        'service',
        'department',
        'part',
        'status',
        'registrationDate',
        'fileNoPrefix',
        'fileNo',
        'issuanceDate',
        'user',
        'ip'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function Order()
    {
        return $this->hasOne(Order::class);
    }


    public function User()
    {
        return $this->belongsTo(User::class);

    }

}
