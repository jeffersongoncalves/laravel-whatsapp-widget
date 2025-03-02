<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('whatsapp_agents', function (Blueprint $table) {
            $table->id();
            $table->boolean('active');
            $table->string('name');
            $table->string('phone');
            $table->string('text')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }
};
