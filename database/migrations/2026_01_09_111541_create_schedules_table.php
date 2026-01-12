<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('film_id')
                  ->constrained('films')
                  ->cascadeOnDelete();

            $table->foreignId('studio_id')
                  ->constrained('studios')
                  ->cascadeOnDelete();

            $table->date('show_date');
            $table->time('show_time');
            $table->integer('price');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
