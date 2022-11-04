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
        Schema::create('notificationtbs', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->text('data');
            $table->integer('byusr')->nullable();
            $table->integer('tousr')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->string('notifiable_id')->nullable();
            $table->string('notifiable_type')->nullable();
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
        Schema::dropIfExists('notifications');
    }
};
