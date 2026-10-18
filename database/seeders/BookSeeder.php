<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    
    public function run(): void {
        Category::create([
            'nama_kategori' => 'Fantasi',
        ]);

        Category::create([
            'nama_kategori' => 'Romansa',
        ]);

        Category::create([
            'nama_kategori' => 'Horor',
        ]);

        Book::create([
            'isbn' => '978-0-618-26020-2',
            'judul' => 'Lord of the Rings',
            'penulis' => 'J.R.R. Tolkien',
            'penerbit' => 'George Allen & Unwin',
            'tahun_terbit' => '1954-07-29',
            'id_kategori' => '1',
            'stok' => '20',
        ]);

        Book::create([
            'isbn' => '978-0-618-26020-3',
            'judul' => 'Harry Potter',
            'penulis' => 'J.K. Rowling',
            'penerbit' => 'Bloomsbury Publishing',
            'tahun_terbit' => '1997-06-26',
            'id_kategori' => '1',
            'stok' => '20',
        ]);

        Book::create([
            'isbn' => '978-0-618-26020-4',
            'judul' => 'The Chronicles of Narnia',
            'penulis' => 'C.S. Lewis',
            'penerbit' => 'George Allen & Unwin',
            'tahun_terbit' => '1950-10-16',
            'id_kategori' => '1',
            'stok' => '20',
        ]);
    }
}
