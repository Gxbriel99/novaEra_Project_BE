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
        Schema::create('attachment_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assistence_request_id');
            $table->string('file_name');
            $table->string('path');
            $table->string('type');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('assistence_request_id')->references('id')->on('assistence_requests');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment_requests');
    }
};
