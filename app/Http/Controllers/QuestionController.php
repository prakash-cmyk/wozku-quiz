<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Show the form for creating a new question for a specific quiz.
     */
    public function create($quiz_id)
    {
        $quiz = DB::table('quizzes')->where('id', $quiz_id)->first();
        return view('questions.create', ['quiz' => $quiz]);
    }

    /**
     * Store the question, marks, and media, and automatically create the correct option.
     */
    public function store(Request $request, $quiz_id)
    {
        try {
            $imagePath = null;
            // Handle Image Upload to Local Storage [cite: 9, 22]
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('questions', 'public');
            }

            // 1. Insert the Question metadata [cite: 36]
            $questionId = DB::table('questions')->insertGetId([
                'quiz_id' => $quiz_id,
                'question_text' => $request->question_text, // Supports HTML/Rich Text [cite: 21]
                'type' => $request->type,
                'marks' => $request->marks ?? 1, // Default marks logic [cite: 31]
                'image_path' => $imagePath,
                'video_url' => $request->video_url, // YouTube support [cite: 23]
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Automatically save the Correct Answer as an Option [cite: 37]
            // This ensures the Evaluation Logic in QuizController has a correct value to compare against.
            DB::table('options')->insert([
                'question_id' => $questionId,
                'option_text' => $request->correct_answer,
                'is_correct' => 1, // Marks this as the true answer [cite: 31]
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Question and Correct Answer added successfully!');
        } catch (\Exception $e) {
            return "ERROR: " . $e->getMessage();
        }
    }

    /**
     * Optional: Manual option management if you want to add additional distractors later.
     */
    public function storeOptions(Request $request, $question_id)
    {
        DB::table('options')->insert([
            'question_id' => $question_id,
            'option_text' => $request->option_text,
            'is_correct' => $request->has('is_correct') ? 1 : 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Additional Option added!');
    }
}
