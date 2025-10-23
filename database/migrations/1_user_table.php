<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id('idUser');
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    /**      * Reverse the migrations.      */     public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
