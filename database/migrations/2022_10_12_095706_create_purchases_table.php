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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('serial_no',10)->unique();
            $table->string('project_serial_no',10)->nullable();
            $table->double('price')->nullable();
            $table->integer('status')->nullable();
            $table->integer('items')->nullable();
            $table->timestamps();

            $table->foreign('project_serial_no')->references('serial_no')->on('projects')->onDelete('set null')->onUpdate('set null');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
};
