<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('desc')->nullable();
            $table->string('img', 100)->nullable();

            $table->integer('project_owner')->unsigned()->index();
            #$table->foreign('project_owner')->references('id')->on('users')->onDelete('cascade');

            $table->integer('created_by')->unsigned()->index();
            #$table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->float('value')->nullable(); //öre
            $table->float('cost')->nullable();  //öre
            $table->dateTime('close_date')->nullable();
            $table->date('deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('projects');
    }
}
