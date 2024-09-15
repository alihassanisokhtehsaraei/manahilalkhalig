<?php

namespace App\Imports;

use App\Models\Coc;
use App\Models\CocGood;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CocGoodsImport implements ToModel, WithHeadingRow
{
    public function __construct(private Coc $coc)
    {

    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

            return new CocGood([
                'quantity' => $row['declared_quantity_unit'] ?? null,
                'value' => $row['goods_value'] ?? null,
                'origin' => $row['origin_as_marked_on_goods'] ?? null,
                'standard' => $row['iqs_no_or_tr'] ?? null,
                'type' => $row['category'] ?? null,
                'desc' => $row['goods_description_designation_brand_model'] ?? null,
                'coc_id' => $this->coc->id,
                'user_id' => Auth::id(), // You can use Auth::id() as a shorthand
                'ip' => request()->ip(),
            ]);

    }
}
