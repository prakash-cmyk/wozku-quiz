# Project Architecture - Wozku Quiz Engine

This document outlines the technical design and data flow of the Quiz application.

## 1. Database Schema (Relational Model)
The application uses a 5-table relational structure:
* **Quizzes**: Stores the quiz title and metadata.
* **Questions**: Linked to Quizzes via `quiz_id`. Supports 5 types (Binary, MCQ, Multi-select, Number, Text).
* **Options**: Linked to Questions via `question_id`. Contains choice text and a boolean `is_correct` flag.
* **Attempts**: Records a user's session, quiz ID, and final calculated score.
* **Answers**: Stores individual user responses linked to an `attempt_id` and `question_id`.

## 2. Controller Logic
* **QuizController**: Handles the core "Attempt" logic. It uses a dynamic scoring algorithm that normalizes input (converting checkbox arrays to strings) and compares them against valid options.
* **QuestionController**: Manages the creation of quiz content and the association of multiple options to a single question.

## 3. Data Flow
1. User selects a quiz from the `index` view.
2. The `attempt` method fetches questions and their related options using Eloquent/DB Query Builder.
3. Upon submission, the `submit` method iterates through the request data, grades each answer based on the `options` table, and persists the results in the `attempts` and `answers` tables.
