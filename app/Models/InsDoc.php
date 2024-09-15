<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InsDoc extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $with = [
        'uploader',
        'reviewer'
    ];
    protected $fillable = [
        'title',
        'category',
        'desc',
        'userID',
        'orderID',
        'status',
        'reviewerID',
        'reviewTime',
        'url',
        'ip'
    ];


    public function Order()
    {
        return $this->belongsTo(Order::class);

    }


    public function uploader()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewerID');
    }
}
