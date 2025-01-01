<?php

namespace Database\Seeders;

use App\Imports\CitiesImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new CitiesImport, storage_path('app/public/data-location-csv/cities.csv'));
    }
}
