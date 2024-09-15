<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rft extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'requestType',
        'applicationType',
        'office',
        'lab',
        'applicantName',
        'applicantAddress',
        'applicantContact',
        'applicantEmail',
        'applicantTel',
        'payerName',
        'payerAddress',
        'payerContact',
        'payerEmail',
        'payerTel',
        'user_id',
        'customer_id',
        'ip',
        'status',
        'cosqcName',
        'insName',
        'customsName',
        'brokerName',
        'inspectionCompany',
        'cocNoOtherCompany',
        'ref',
        'date',
        'note',
        'order_id',
        'finNote',
        'transactionNo',
        'labPaymentMethod',
        'labFeePlace',
        'subSum',
        'tax',
        'totalFee',
        'financialStatus',
        'finAppUser',
        'finAppDate'

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function rftsample()
    {
        return $this->hasMany(RftSamples::class);
    }

}
