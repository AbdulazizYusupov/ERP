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
        Schema::create('machine_produces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained('machines')->onDelete('cascade');
            $table->foreignId('produce_id')->constrained('produces')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('count');
            $table->integer('defect')->default(0);
            $table->integer('quality')->default(0);
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_produces');
    }
};
