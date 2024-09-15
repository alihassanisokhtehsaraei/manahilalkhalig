<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ncr extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $with = [
        'Order'
    ];
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'certNo',
        'order_id',
        'issuingDate',
        'regNo',
        'rfi',
        'importer',
        'importerAdd',
        'importerCityCountry',
        'exporter',
        'exporterAdd',
        'exporterCityCountry',
        'invAmount',
        'invCurrency',
        'invNo',
        'invDate',
        'remarks',
        'signee',
        'issuingPlace',
        'disclaimer',
        'ip',
        'user_id',
        'reason',
        'reviewer_id',
        'reviewDate'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function ncrGoods()
    {
        return $this->hasMany(NcrGood::class);
    }
}
