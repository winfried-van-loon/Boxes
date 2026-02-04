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
        Schema::create('boxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            $table->string('type')->nullable();
            $table->foreignId('current_room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->string('current_location')->nullable();
            $table->foreignId('target_room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->string('target_location')->nullable();
            $table->foreignId('parent_box_id')->nullable()->constrained('boxes')->onDelete('set null');
            $table->text('description')->nullable();
            $table->json('custom_fields')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boxes');
    }
};
