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
        Schema::create('attachments_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idTicket');
            $table->string('fileName');
            $table->string('path');
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('idTicket')->references('idTicket')->on('assistence_request');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments_requests');
    }
};
