<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * 1. Display a listing of all quizzes.
     */
    public function index()
    {
        $quizzes = DB::table('quizzes')->get();
        return view('quiz.index', ['quizzes' => $quizzes]);
    }

    /**
     * 2. Show the form for creating a new quiz.
     */
    public function create()
    {
        return view('quiz.create');
    }

    /**
     * 3. Store a newly created quiz in the database.
     */
    public function store(Request $request)
    {
        try {
            DB::table('quizzes')->insert([
                'title' => $request->title,
                'description' => $request->description,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->route('quiz.index')->with('success', 'Quiz created successfully!');
            
        } catch (\Exception $e) {
            return "DATABASE ERROR: " . $e->getMessage();
        }     
    }

    /**
     * 4. Display the quiz for a user to attempt.
     */
    public function attempt($quiz_id)
    {
        $quiz = DB::table('quizzes')->where('id', $quiz_id)->first();
        
        if (!$quiz) {
            return "Error: Quiz not found.";
        }

        // Get all questions for this quiz
        $questions = DB::table('questions')->where('quiz_id', $quiz_id)->get();
        
        // Attach options to each question for the UI
        foreach ($questions as $question) {
            $question->options = DB::table('options')->where('question_id', $question->id)->get();
        }

        return view('quiz.attempt', compact('quiz', 'questions'));
    }

    /**
     * 5. Process the quiz submission and calculate score.
     * This handles Text, Number, Radio (MCQ/Binary), and Checkbox (Multiple) inputs.
     */
    public function submit(Request $request, $quiz_id)
    {
        try {
            $questions = DB::table('questions')->where('quiz_id', $quiz_id)->get();
            $totalScore = 0;

            // Create a new Attempt record to track the user's progress
            $attemptId = DB::table('attempts')->insertGetId([
                'quiz_id' => $quiz_id,
                'total_score' => 0, 
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($questions as $question) {
                // Fetch the input from the form (might be a string or an array)
                $userAnswer = $request->input('question_' . $question->id);
                
                // DATA NORMALIZATION:
                // If the answer is an array (from checkboxes), convert to a comma-separated string
                if (is_array($userAnswer)) {
                    $userAnswerString = implode(', ', $userAnswer);
                } else {
                    $userAnswerString = $userAnswer ?? '';
                }

                $isCorrect = false;

                // GRADING LOGIC:
                // Find all options marked as 'correct' for this specific question
                $correctOptions = DB::table('options')
                    ->where('question_id', $question->id)
                    ->where('is_correct', 1)
                    ->get();

                foreach ($correctOptions as $option) {
                    // Checkbox Logic: If the correct option text is inside the submitted array
                    if (is_array($userAnswer)) {
                        if (in_array($option->option_text, $userAnswer)) {
                            $isCorrect = true;
                            $totalScore += 1; 
                            break; 
                        }
                    } 
                    // Radio/Text/Number Logic: Simple string comparison
                    else {
                        if (trim(strtolower($option->option_text)) == trim(strtolower($userAnswerString))) {
                            $isCorrect = true;
                            $totalScore += 1;
                            break;
                        }
                    }
                }

                // Persist the individual answer to the database
                DB::table('answers')->insert([
                    'attempt_id' => $attemptId,
                    'question_id' => $question->id,
                    'user_answer' => $userAnswerString,
                    'is_correct' => $isCorrect,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Finalize the overall quiz score in the attempts table
            DB::table('attempts')->where('id', $attemptId)->update(['total_score' => $totalScore]);

            return "<h2>Quiz Submitted Successfully!</h2>
                    <p>Your Total Score: <strong>" . $totalScore . " / " . count($questions) . "</strong></p>
                    <a href='/quizzes'>Back to Dashboard</a>";

        } catch (\Exception $e) {
            // Safety net to catch errors and prevent the ReflectionProperty 500 crash
            return "SUBMISSION ERROR: " . $e->getMessage();
        }
    }
}