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
        Schema::create('assistence_request', function (Blueprint $table) {
            $table->id('idTicket');
            $table->string('email');
            $table->string('oggetto');
            $table->string('descrizione',500);
            $table->json('allegati')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistence_request');
    }
};
