<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('whatsapp_logs', function (Blueprint $table) {
            $table->id();
            $table->json('agent')->nullable();
            $table->json('number')->nullable();
            $table->json('geo')->nullable();
            $table->string('type')->nullable();
            $table->string('ref')->nullable();
            $table->timestamps();
        });
    }
};
