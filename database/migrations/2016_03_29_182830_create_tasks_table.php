<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('desc')->nullable();
            $table->string('img', 100)->nullable();

            $table->integer('created_by')->unsigned()->index();
            #$table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->integer('responsible')->unsigned()->index();
            #$table->foreign('responsible')->references('id')->on('users')->onDelete('cascade');

            $table->integer('prio')->unsigned();
            $table->string('stage'); //backlog, ongoing, done
            $table->date('deadline')->nullable();
            
            $table->integer('project_id')->unsigned()->index();
            #$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            
            $table->dateTime('compleated_date')->nullable();
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
        Schema::drop('tasks');
    }
}
