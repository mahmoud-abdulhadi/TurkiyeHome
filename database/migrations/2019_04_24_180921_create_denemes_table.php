<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDenemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denemes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';
            $table->increments('id');
            $table->string('title',100)->unique();
            $table->integer('term')->unsigned();
            $table->boolean('active')->default(true);
            $table->string('type',30);
            $table->string('src')->unique();
            $table->unsignedInteger('class_id');
            $table->timestamps();

            $table->foreign('class_id')
                    ->references('id')
                    ->on('classes')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('denemes');
    }
}
