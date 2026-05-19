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
        Schema::create('navaids', function (Blueprint $table) {
            $table->id();

            $table->string('identifier')->unique();

            $table->string('name');

            $table->enum('type', [
                'VOR',
                'DME',
                'VOR_DME',
                'NDB',
                'TACAN'
            ]);

            $table->decimal('frequency', 6, 2)->nullable();

            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navaids');
    }
};
