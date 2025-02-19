<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('score_results', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number', 25);
            $table->string('result', 10);
            $table->integer('score');
            $table->timestamps();

            $table->index('phone_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('score_results');
    }
};
