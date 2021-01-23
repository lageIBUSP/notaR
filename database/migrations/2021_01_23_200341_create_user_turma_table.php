<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTurmaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_turma', function (Blueprint $table) {
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
        Schema::dropIfExists('user_turma');
    }
}
