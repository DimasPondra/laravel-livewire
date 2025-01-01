<?php

namespace Database\Seeders;

use App\Imports\ProvincesImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new ProvincesImport, storage_path('app/public/data-location-csv/provinces.csv'));
    }
}
