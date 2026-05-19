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
        Schema::create('route_waypoint', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ats_route_id')
                  ->constrained('ats_routes')
                  ->onDelete('cascade');

            $table->foreignId('waypoint_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->integer('sequence_order');

            $table->timestamps();

            $table->unique([
                'ats_route_id',
                'sequence_order'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_waypoint');
    }
};
