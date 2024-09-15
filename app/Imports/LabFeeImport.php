<?php

namespace App\Imports;

use App\Models\LabFee;
use Maatwebsite\Excel\Concerns\ToModel;

class LabFeeImport implements ToModel
{

    public function model(array $row)
    {

        return new LabFee([
            'arabic_name' => $row[0],
            'english_name' => $row[1],
            'fee' => $row[2],
            'category' => $row[3],

        ]);
    }
}
