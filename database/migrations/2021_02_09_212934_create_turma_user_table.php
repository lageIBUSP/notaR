<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurmaUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turma_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('turma_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->unique(['turma_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turma_user');
    }
}
