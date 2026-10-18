<?php

namespace Database\Seeders;

use App\Models\Borrowing;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BorrowingSeeder extends Seeder
{
    public function run(): void {
        Borrowing::create([
            'id_buku' => 1,
            'id_user' => 2,
            'tanggal_pinjam' => now(),
            'jatuh_tempo' => now()->addDays(7)
        ]);

        Borrowing::create([
            'id_buku' => 2,
            'id_user' => 2,
            'tanggal_pinjam' => now(),
            'jatuh_tempo' => now()
        ]);

        Borrowing::create([
            'id_buku' => 3,
            'id_user' => 2,
            'tanggal_pinjam' => now(),
            'jatuh_tempo' => now()->subDays(2),
            'status' => 'terlambat'
        ]);
    }
}
