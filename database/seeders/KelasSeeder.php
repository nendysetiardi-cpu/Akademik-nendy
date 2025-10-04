<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    Kelas::create(['namaKelas' => 'ASE-1A', 'kapasitas' => 30]);
    Kelas::create(['namaKelas' => 'TI-1B', 'kapasitas' => 30]);
    Kelas::create(['namaKelas' => 'TI-1C', 'kapasitas' => 30]);
    }
}
