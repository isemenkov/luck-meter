<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Statuses\AccessTokenStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('access_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('phone_number', 25);
            $table->string('access_token', 100);
            $table->timestamp('valid_till');
            $table->string('status', 50)->default(AccessTokenStatus::ACTIVE->value);
            $table->timestamps();

            $table->unique('access_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('access_tokens');
    }
};
