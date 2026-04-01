# Wozku Quiz Application

A robust Laravel-based Quiz engine supporting 5 distinct question types: Binary, MCQ, Multiple Choice (Checkboxes), Number, and Text.

## 🚀 Features
* **Dynamic Scoring**: Automatically evaluates answers using a type-agnostic engine, including complex array-based checkbox logic.
* **Media Support**: Supports rich text/HTML, local image uploads, and embedded YouTube videos for every question.
* **Relational Database**: Implements a 5-table schema to track quizzes, questions, options, user attempts, and individual answers.
* **Responsive UI**: Clean interface built with Laravel Blade templates and Bootstrap.

## 🛠️ Installation & Setup
1. **Clone** this repository to your local machine.
2. Run `composer install` to install all PHP dependencies.
3. **Configure Environment**: Copy `.env.example` to `.env` and set your database credentials (MySQL or SQLite).
4. **Database Migration**: Run `php artisan migrate` to build the required table structure.
5. **Storage Link (Crucial)**: Run `php artisan storage:link` to enable local storage visibility for uploaded question images.
6. **Launch**: Run `php artisan serve` and navigate to `http://127.0.0.1:8000`.

## ⏱️ Project Timeline & Planning
**Total Estimated Time: 14 Hours**
* **Data Modeling (3 Hours)**: Designing the 5-table relational schema and setting up migrations/factories.
* **Core Logic (5 Hours)**: Developing the QuizController evaluation engine and QuestionController media handling.
* **Frontend Development (4 Hours)**: Building Blade views for quiz attempts, creation, and result displays.
* **Testing & Documentation (2 Hours)**: Performing cross-type validation (the 10/10 score test) and drafting Architecture/AI logs.

**Planning Strategy**: I arrived at this estimate by prioritizing the database schema first to ensure data integrity, followed by the "Type-Agnostic" scoring logic to meet extensibility requirements early in the cycle.

## 📄 Documentation
* **Architecture**: Detailed design decisions and extensibility patterns are located in ARCHITECTURE.md.
* **AI Usage**: A full log of AI prompts, corrections, and troubleshooting (including environment-specific fixes) is located in AI_USAGE.md.
