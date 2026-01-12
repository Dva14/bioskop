<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('studios', function (Blueprint $table) {
            $table->id();                 // Primary key
            $table->string('name');       // Nama studio
            $table->integer('capacity');  // Kapasitas kursi
            $table->timestamps();         // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('studios');
    }
};
