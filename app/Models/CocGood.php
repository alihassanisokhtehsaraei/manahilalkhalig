<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CocGood extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'quantity',
        'value',
        'origin',
        'desc',
        'standard',
        'type',
        'coc_id',
        'user_id',
        'ip'
    ];


    public function coc()
    {
        return $this->belongsTo(Coc::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
