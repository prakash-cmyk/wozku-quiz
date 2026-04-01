<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This schema supports all 5 required question types and media requirements.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            
            // Relationship to the quizzes table
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            
            // Core Question Data
            $table->text('question_text'); // Supports HTML/Rich Text 
            $table->string('type'); // Binary, Single, Multiple, Number, Text [cite: 15, 16, 17, 18, 19]
            
            // Marking Logic
            $table->integer('marks')->default(1); // Default value as per PDF [cite: 31]
            
            // Media Support
            $table->string('image_path')->nullable(); // Local storage for images [cite: 9, 22]
            $table->string('video_url')->nullable(); // YouTube/Video URL support [cite: 23]
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};