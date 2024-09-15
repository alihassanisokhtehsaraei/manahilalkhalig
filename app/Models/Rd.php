<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rd extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $with = [
        'Coc',
    ];
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'docNo',
        'issuingDate',
        'entryPort',
        'importer',
        'certNo',
        'certExpDate',
        'items',
        'conPack',
        'imDoc',
        'noLine',
        'shipmentType',
        'shipmentDetails',
        'total',
        'tArrived',
        'arrived',
        'pending',
        'comments',
        'disclaimer',
        'signee',
        'user_id',
        'reviewer_id',
        'reviewDate',
        'ip',
        'coc_id',
        'order_id',
        'type',
        'reason',
        'status',
        'extra',
        'lifetime',
        'visibility'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function coc()
    {
        return $this->belongsTo(Coc::class);
    }

    public function rds()
    {
        return $this->hasMany(Rd::class);
    }
}
