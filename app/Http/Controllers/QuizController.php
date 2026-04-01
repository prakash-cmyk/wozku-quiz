<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * Display a listing of all quizzes.
     */
    public function index()
    {
        $quizzes = DB::table('quizzes')->get();
        return view('quiz.index', ['quizzes' => $quizzes]);
    }

    /**
     * Show the form for creating a new quiz. 
     */
    public function create()
    {
        return view('quiz.create');
    }

    /**
     * Store a newly created quiz in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $quizId = DB::table('quizzes')->insertGetId([
            'title' => $request->title,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('quiz.index')->with('success', 'Quiz created successfully!');
    }

    /**
     * Show the quiz attempt page with all questions and options.
     */
    public function attempt($quiz_id)
    {
        $quiz = DB::table('quizzes')->where('id', $quiz_id)->first();
        $questions = DB::table('questions')->where('quiz_id', $quiz_id)->get();
        
        foreach ($questions as $question) {
            $question->options = DB::table('options')->where('question_id', $question->id)->get();
        }

        return view('quiz.attempt', compact('quiz', 'questions'));
    }

    /**
     * Handle quiz submission and calculate scores dynamically.
     */
    public function submit(Request $request, $quiz_id)
    {
        try {
            $questions = DB::table('questions')->where('quiz_id', $quiz_id)->get();
            $totalScore = 0;

            // Initialize the attempt record
            $attemptId = DB::table('attempts')->insertGetId([
                'quiz_id' => $quiz_id,
                'total_score' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($questions as $question) {
                $userAnswer = $request->input('question_' . $question->id);
                $isCorrect = false;

                // 1. Get the correct options from the database
                $correctOptions = DB::table('options')
                    ->where('question_id', $question->id)
                    ->where('is_correct', 1)
                    ->get();

                // 2. Logic for Multiple Choice (Checkboxes)
                if ($question->type == 'Multiple' && is_array($userAnswer)) {
                    // Get all stored correct answers into a clean array
                    $storedCorrectAnswers = [];
                    foreach ($correctOptions as $option) {
                        // Split by comma in case multiple answers are in one row
                        $parts = explode(',', $option->option_text);
                        foreach ($parts as $part) {
                            $storedCorrectAnswers[] = trim(strtolower($part));
                        }
                    }

                    // Clean user answers
                    $cleanedUserAnswers = array_map('trim', array_map('strtolower', $userAnswer));

                    // Check if user selected exactly the right number of items and if they match
                    if (count($storedCorrectAnswers) === count($cleanedUserAnswers)) {
                        $isCorrect = (count(array_diff($storedCorrectAnswers, $cleanedUserAnswers)) === 0);
                    }
                } 
                // 3. Logic for Single/Binary/Number/Text
                else {
                    $userAnswerString = trim(strtolower((string)$userAnswer));
                    foreach ($correctOptions as $option) {
                        if (trim(strtolower($option->option_text)) == $userAnswerString) {
                            $isCorrect = true;
                            break;
                        }
                    }
                }

                // 4. Update Score
                if ($isCorrect) {
                    $totalScore += $question->marks;
                }

                // 5. Store individual answer record
                $storageValue = is_array($userAnswer) ? implode(', ', $userAnswer) : ($userAnswer ?? '');
                DB::table('answers')->insert([
                    'attempt_id' => $attemptId,
                    'question_id' => $question->id,
                    'user_answer' => $storageValue,
                    'is_correct' => $isCorrect,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Update total score for the attempt
            DB::table('attempts')->where('id', $attemptId)->update(['total_score' => $totalScore]);

            return view('quiz.result', [
                'score' => $totalScore, 
                'total' => $questions->sum('marks') 
            ]);

        } catch (\Exception $e) {
            return "SUBMISSION ERROR: " . $e->getMessage();
        }
    }
}