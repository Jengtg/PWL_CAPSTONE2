<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // <-- TAMBAHKAN INI

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan pemeriksaan foreign key sementara
        Schema::disableForeignKeyConstraints();

        // Kosongkan tabel
        DB::table('status')->truncate();

        // Aktifkan kembali pemeriksaan foreign key
        Schema::enableForeignKeyConstraints();

        // Masukkan data status yang dibutuhkan
        DB::table('status')->insert([
            ['id' => 1, 'name' => 'Menunggu Pembayaran'],
            ['id' => 2, 'name' => 'Pembayaran Diterima'],
            ['id' => 3, 'name' => 'Hadir'],
            ['id' => 4, 'name' => 'Tidak Hadir'],
            ['id' => 5, 'name' => 'Dibatalkan'],
        ]);
    }
}