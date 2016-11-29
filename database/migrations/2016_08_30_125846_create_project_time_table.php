<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_times', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by')->unsigned()->index();
            $table->integer('project_id')->unsigned()->index();
            $table->date('startdate');
            $table->date('enddate');
            $table->integer('hours');
            $table->date('billed')->nullable();
            $table->date('payed')->nullable();
            $table->softDeletes();
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
        Schema::drop('project_times');
    }
}
