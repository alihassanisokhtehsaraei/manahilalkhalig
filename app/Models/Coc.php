<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coc extends Model
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
        'expDate',
        'regNo',
        'refNo',
        'importerName',
        'importerAdd',
        'importerCityCountry',
        'importerLicence',
        'importerLicenceDate',
        'exporterName',
        'exporterAdd',
        'exporterCityCountry',
        'invAmount',
        'invCurrency',
        'invUSD',
        'invNo',
        'invDate',
        'invValPerTruck',
        'shipmentCountry',
        'blNo',
        'blDate',
        'packingDetails',
        'numTypePacking',
        'containerDetails',
        'sealNo',
        'remark',
        'assessment',
        'comments',
        'signee',
        'issuingPlace',
        'disclaimer',
        'ip',
        'user_id',
        'reviewer_id',
        'reviewDate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function goods()
    {
        return $this->hasMany(CocGood::class);
    }

    public function releaseDocuments()
    {
        return $this->hasMany(ReleaseDocument::class);
    }
}
