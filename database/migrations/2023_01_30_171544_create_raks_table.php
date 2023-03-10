<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('raks', function (Blueprint $table) {
            $table->id();
            $table->string('rak');
            $table->enum('tipe', ['fq', 'qbs']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('raks');
    }
};
