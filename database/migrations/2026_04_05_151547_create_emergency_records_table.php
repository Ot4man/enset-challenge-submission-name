<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emergency_records', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->text('message');
            $blueprint->string('type');
            $blueprint->string('risk_level');
            $blueprint->json('actions');
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emergency_records');
    }
};
