<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('serial_no',10)->unique();
            $table->bigInteger('uid')->unsigned();
            $table->bigInteger('admin')->unsigned();
            $table->string('pname');
            $table->string('photo')->nullable();
            $table->double('length')->nullable();
            $table->double('width')->nullable();
            $table->double('height')->nullable();
            $table->string('unit')->nullable();
            $table->double('volume')->nullable();
            $table->string('cubic_unit');
            $table->integer('type');
            $table->integer('daysneed');
            $table->integer('machine_voltage');
            $table->string('details')->nullable();
            $table->double('totlal');
            $table->date('due_time')->nullable();
            $table->integer('isApproved');
            $table->integer('phase')->default(0);
            $table->dateTime('approved_date')->nullable();
            $table->json('phases_times');
            $table->timestamps();

            $table->foreign('uid')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('admin')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // when drop Projects table, it will need to delete all dependant tables before.
        Schema::dropIfExists('project_motors');
        Schema::dropIfExists('project_metals');
        Schema::dropIfExists('project_others');
        Schema::dropIfExists('project_vertical_photo');
        Schema::dropIfExists('project_horizontal_photo');
        Schema::dropIfExists('project_diagram_photo');

        Schema::dropIfExists('projects');
        //DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
