<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('make_id');
            $table->integer('model_id')->nullable();
            $table->integer('year')->default(0);
            $table->integer('thruster_type_id')->nullable();
            $table->text('wiring_info')->nullable();
            $table->text('thruster_info')->nullable();
            $table->date('done_on_date')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_infos');
    }
}
