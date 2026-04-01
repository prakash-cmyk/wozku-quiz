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
    // Records the overall quiz result 
    Schema::create('attempts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('quiz_id')->constrained();
        $table->integer('total_score')->default(0); // [cite: 31, 32]
        $table->timestamps();
    });

    // Records individual answers for grading 
    Schema::create('answers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('attempt_id')->constrained();
        $table->foreignId('question_id')->constrained();
        $table->text('user_answer'); // [cite: 28]
        $table->boolean('is_correct')->default(false); // [cite: 31]
        $table->timestamps();
    });
 }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attempts_and_answers_tables');
    }
};
