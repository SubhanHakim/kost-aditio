<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tipe_kamars', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tipe');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 10, 2); // Assuming harga is a decimal value
            $table->json('image')->nullable(); // Optional image field for the type of room
            $table->integer('total_kamar')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_kamars');
    }
};
