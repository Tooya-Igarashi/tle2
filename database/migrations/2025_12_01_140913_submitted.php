<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submitted', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->foreignId('challenge_id')->constrained('challenges')->cascadeOnDelete();
            $table->text('content')->nullable();
            $table->boolean('pending')->default(true);
            $table->bigInteger('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submitted');
    }
};
