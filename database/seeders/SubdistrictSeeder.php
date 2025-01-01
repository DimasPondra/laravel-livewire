<?php

namespace Database\Seeders;

use App\Imports\SubdistrictsImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class SubdistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new SubdistrictsImport, storage_path('app/public/data-location-csv/subdistricts.csv'));
    }
}
