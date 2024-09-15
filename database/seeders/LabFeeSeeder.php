<?php

namespace Database\Seeders;

use App\Imports\LabFeeImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class LabFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new LabFeeImport(), storage_path('excels/imports/labfees.xlsx'));
    }
}
