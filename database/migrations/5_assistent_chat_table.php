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
        Schema::create('assistent_chat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idTicket'); // relazione con assistence_request
            $table->unsignedBigInteger('idUser');   // relazione con users
            $table->string('message', 500)->nullable();
            $table->string('response', 500)->nullable();
            $table->unsignedBigInteger('idAttachment')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idUser')->references('idUser')->on('user');
            $table->foreign('idTicket')->references('idTicket')->on('assistence_request');
            $table->foreign('idAttachment')->references('idAttachment')->on('attachment_request');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistent_chat');
    }
};
