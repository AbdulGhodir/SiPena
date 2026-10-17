<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('isbn', 20)->unique();
            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit');
            $table->string('tahun_terbit');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('stok')->default(0);
            $table->string('gambar')->nullable();
            $table->foreignId('id_kategori')->constrained('categories')->onDelete('restrict');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
