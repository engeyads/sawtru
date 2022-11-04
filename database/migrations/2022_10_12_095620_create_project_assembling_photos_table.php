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
        Schema::create('project_assembling_photos', function (Blueprint $table) {
            $table->id();
            $table->string('project_serial_no',10);
            $table->string('name')->nullable();
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
        Schema::dropIfExists('project_assembling_photos');
    }
};
