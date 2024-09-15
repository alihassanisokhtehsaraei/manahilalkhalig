<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coi extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'certNo',
        'order_id',
        'issuingDate',
        'exporter',
        'applicant',
        'consignee',
        'refDoc',
        'notifyParty',
        'loadingPort',
        'dischargePort',
        'invNo',
        'invDate',
        'commodity',
        'insPlace',
        'insDate',
        'insNote',
        'conclusion',
        'user_id',
        'branch',
        'userBranch',
        'ip',
        'remark',
        'reviewer_id',
        'reviewDate'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function goods()
    {
        return $this->hasMany(CoiGood::class);
    }

    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
