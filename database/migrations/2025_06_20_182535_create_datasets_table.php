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
        Schema::create('datasets', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('kelas');

        // Visual
        $table->tinyInteger('v1');
        $table->tinyInteger('v2');
        $table->tinyInteger('v3');
        $table->tinyInteger('v4');
        $table->tinyInteger('v5');
        $table->tinyInteger('hasil_visual');

        // Auditori
        $table->tinyInteger('a6');
        $table->tinyInteger('a7');
        $table->tinyInteger('a8');
        $table->tinyInteger('a9');
        $table->tinyInteger('a10');
        $table->tinyInteger('hasil_auditori');

        // Kinestetik
        $table->tinyInteger('k11');
        $table->tinyInteger('k12');
        $table->tinyInteger('k13');
        $table->tinyInteger('k14');
        $table->tinyInteger('k15');
        $table->tinyInteger('hasil_kinestetik');

        $table->string('hasil_akhir');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datasets');
    }
};
