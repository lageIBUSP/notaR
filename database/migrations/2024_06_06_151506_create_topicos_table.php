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
        Schema::create('topicos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('order')->unsigned()->unique();
            $table->timestamps();
        });
        Schema::table('exercicios', function (Blueprint $table) {
            $table->foreignId('topico_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercicios', function (Blueprint $table) {
            $table->dropForeign(['topico_id']);
            $table->dropColumn('topico_id');
        });
        Schema::dropIfExists('topicos');
    }
};
