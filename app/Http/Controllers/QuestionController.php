<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * 1. Show the form for creating a question for a specific quiz.
     */
    public function create($quiz_id)
    {
        $quiz = DB::table('quizzes')->where('id', $quiz_id)->first();
        return view('questions.create', ['quiz' => $quiz]);
    }

    /**
     * 2. Store the question in the database.
     */
    public function store(Request $request, $quiz_id)
    {
        try {
            DB::table('questions')->insert([
                'quiz_id' => $quiz_id,
                'question_text' => $request->question_text,
                'type' => $request->type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Question added successfully!');
            
        } catch (\Exception $e) {
            return "DATABASE ERROR: " . $e->getMessage();
        }
    }

    /**
     * 3. Show the form to add options to a specific question.
     */
    public function createOptions($question_id)
    {
        $question = DB::table('questions')->where('id', $question_id)->first();
        
        if (!$question) {
            return "Error: Question not found.";
        }

        return view('options.create', ['question' => $question]);
    }

    /**
     * 4. Store the option (Choice) and mark if it is correct.
     * Note: Using explicit namespace for Request to prevent Reflection errors.
     */
    public function storeOptions(\Illuminate\Http\Request $request, $question_id)
    {
        try {
            DB::table('options')->insert([
                'question_id' => $question_id,
                'option_text' => $request->option_text,
                'is_correct' => $request->has('is_correct') ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Option added successfully!');
            
        } catch (\Exception $e) {
            // This prevents the 500 Reflection error and shows the real issue
            return "ERROR SAVING OPTION: " . $e->getMessage();
        }
    }
}
