<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController; 

// Redirect the root URL directly to your Quiz List [cite: 13, 27]
Route::get('/', [QuizController::class, 'index'])->name('home');

// Quiz Management Routes [cite: 12, 13]
Route::get('/quizzes', [QuizController::class, 'index'])->name('quiz.index');
Route::get('/quiz/create', [QuizController::class, 'create'])->name('quiz.create');
Route::post('/quiz/store', [QuizController::class, 'store'])->name('quiz.store');

// Question Routes with Media Support [cite: 20, 21, 22, 23]
Route::get('/quiz/{quiz_id}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/quiz/{quiz_id}/questions/store', [QuestionController::class, 'store'])->name('questions.store');

// Options Management [cite: 24, 25]
Route::get('/question/{question_id}/options/create', [QuestionController::class, 'createOptions'])->name('options.create');
Route::post('/question/{question_id}/options/store', [QuestionController::class, 'storeOptions'])->name('options.store');

// Quiz Attempt and Evaluation Logic [cite: 27, 28, 29, 30, 31, 32, 33]
Route::get('/quiz/{quiz_id}/attempt', [QuizController::class, 'attempt'])->name('quiz.attempt');
Route::post('/quiz/{quiz_id}/submit', [QuizController::class, 'submit'])->name('quiz.submit');