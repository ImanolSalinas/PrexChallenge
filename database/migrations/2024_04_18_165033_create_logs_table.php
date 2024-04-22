<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id(); // Clave primaria autoincremental
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->string('service'); 
            $table->json('request_body'); 
            $table->integer('http_code'); 
            $table->json('response_body'); 
            $table->string('ip_origin'); 
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
