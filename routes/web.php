<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController; 

Route::get('/', function () {
    return view('welcome');
});

// Quiz Routes
Route::get('/quiz/create', [QuizController::class, 'create'])->name('quiz.create');
Route::post('/quiz/store', [QuizController::class, 'store'])->name('quiz.store');
Route::get('/quizzes', [QuizController::class, 'index'])->name('quiz.index');

// Question Routes (This fixes the 404)
Route::get('/quiz/{quiz_id}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/quiz/{quiz_id}/questions/store', [QuestionController::class, 'store'])->name('questions.store');

Route::get('/question/{question_id}/options/create', [QuestionController::class, 'createOptions'])->name('options.create');
Route::post('/question/{question_id}/options/store', [QuestionController::class, 'storeOptions'])->name('options.store');

// Route to view/attempt the quiz
Route::get('/quiz/{quiz_id}/attempt', [QuizController::class, 'attempt'])->name('quiz.attempt');

// Route to submit and calculate results
Route::post('/quiz/{quiz_id}/submit', [QuizController::class, 'submit'])->name('quiz.submit');