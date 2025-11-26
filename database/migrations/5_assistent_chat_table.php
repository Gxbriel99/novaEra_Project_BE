<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assistent_chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assistence_request_id'); // relazione con assistence_request
            $table->unsignedBigInteger('user_id');   // relazione con users
            $table->string('message', 500)->nullable();
            $table->string('response', 500)->nullable();
            $table->unsignedBigInteger('attachment_request_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('assistence_request_id')->references('id')->on('assistence_requests');
            $table->foreign('attachment_request_id')->references('id')->on('attachment_requests');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistent_chats');
    }
};
