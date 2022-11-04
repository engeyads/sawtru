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
        Schema::create('project_lasers', function (Blueprint $table) {
            $table->id();
            $table->string('project_serial_no',10);
            $table->double('laser_cutting')->nullable();
            $table->double('cnc')->nullable();
            $table->double('torna')->nullable();
            $table->double('assembling')->nullable();
            $table->double('electric_and_automation')->nullable();
            $table->double('total')->nullable();
            $table->timestamps();
            $table->foreign('project_serial_no')->references('serial_no')->on('projects')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_lasers');
    }
};
