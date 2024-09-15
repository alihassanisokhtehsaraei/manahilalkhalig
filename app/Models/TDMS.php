<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TDMS extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $table = 'tdms';
    protected $fillable = [
        'no',
        'docType',
        'mgmtCode',
        'actCode',
        'version',
        'title',
        'modDesc',
        's17020',
        's17025',
        's9001',
        's14001',
        's45001',
        'pages',
        'userLevel1',
        'userLevel2',
        'userLevel3',
        'releaseDate',
        'releaseDateGregorian',
        'status',
        'place1',
        'place2',
        'place3',
        'place4',
        'place5',
        'place6',
        'place7',
        'place8',
        'place9',
        'place10',
        'place11',
        'place12',
        'place13',
        'place14',
        'place15',
        'place16',
        'place17',
        'branch1',
        'branch2',
        'branch3',
        'branch4',
        'branch5',
        'branch6',
        'branch7',
        'branch8',
        'branch9',
        'branch10',
        'creator',
        'userInCharge1',
        'userInCharge1Date',
        'userInCharge2',
        'userInCharge2Date',
        'userInCharge3',
        'userInCharge3Date',
        'userInCharge4',
        'userInCharge4Date',
        'pdfUrl',
        'nativeUrl',
        'ip'

    ];

    protected $dates = ['deleted_at'];
}
