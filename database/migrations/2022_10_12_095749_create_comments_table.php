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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('project_serial_no',10)->nullable();
            $table->string('purchases_serial_no',10)->nullable();
            $table->bigInteger('byid')->unsigned();
            $table->bigInteger('toid')->unsigned();
            $table->string('content');
            $table->integer('isRead')->default(0);
            $table->integer('available')->default(1);
            $table->dateTime('removed_at')->nullable();
            $table->bigInteger('removed_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('purchases_serial_no')->references('serial_no')->on('purchases')->onDelete('set null')->onUpdate('set null');
            $table->foreign('project_serial_no')->references('serial_no')->on('projects')->onDelete('set null')->onUpdate('set null');
            $table->foreign('byid')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('toid')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('removed_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
