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
        Schema::create('activity_loggers', function (Blueprint $table) {
            $table->id();
            $table->longText('description')->nullable();
            $table->longText('payload')->nullable();
            $table->string('userType')->nullable();
            $table->integer('userId')->nullable();
            $table->longText('route')->nullable();
            $table->ipAddress('ipAddress')->nullable();
            $table->text('userAgent')->nullable();
            $table->longText('referer')->nullable();
            $table->string('methodType')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_loggers');
    }
};
