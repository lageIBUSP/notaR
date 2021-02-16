<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrazosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prazos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('prazo');
            $table->foreignId('turma_id')->constrained();
            $table->foreignId('exercicio_id')->constrained();
            $table->unique(['turma_id','exercicio_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prazos', function (Blueprint $table) {
                //
                });
    }
}
