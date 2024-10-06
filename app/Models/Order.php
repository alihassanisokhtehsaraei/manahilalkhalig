<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $with = [
        'Customer',
    ];
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'tracking_no',
        'exporter',
        'desc',
        'service',
        'piNo',
        'country_origin',
        'container',
        'container_pending',
        'border',
        'shipmentMethod',
        'shipmentType',
        'customer_id',
        'user_id',
        'branch',
        'ip',
        'technicalStatus',
        'financialStatus',
        'invoiceValue',
        'insFee',
        'borderFeeTotal',
        'borderFeeEach',
        'insFeePlace',
        'borderFeePlace',
        'finAppUser',
        'finAppDate',
        'finNote',
        'reversion',
        'v1',
        'v2',
        'v3',
        'cocPaymentMethod',
        'borderPaymentMethod',
        'transactionNo',
        'category',

        // New fields
        'exporter_contact_person_name',
        'exporter_address',
        'exporter_city_country',
        'exporter_phone',
        'importer_company_name',
        'importer_contact_person_name',
        'importer_address',
        'importer_city_country',
        'importer_phone',
    ];

    public function Customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);

    }

    public function ncr()
    {
        return $this->hasOne(Ncr::class);
    }

    public function coc()
    {
        return $this->hasOne(Coc::class);
    }

    public function releaseDocuments()
    {
        return $this->hasManyThrough(ReleaseDocument::class, Coc::class);
    }

    public function nonReleaseDocuments()
    {
        return $this->hasManyThrough(NonReleaseDocument::class, Coc::class);
    }

    public function rft()
    {
        return $this->hasMany(Rft::class);
    }
}
