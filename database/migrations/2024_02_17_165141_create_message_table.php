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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->longText('text_message')->nullable();
            $table->integer('send_time');
            $table->unsignedBigInteger('user_id');
            $table->text('chat_name')->nullable();
            $table->enum('chat_type', ['pv','group','channel'])->default('group');
            $table->text('content_name')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
