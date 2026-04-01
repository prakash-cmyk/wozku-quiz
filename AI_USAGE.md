# AI Usage Log - Wozku Quiz Project

## 1. Project Overview
I utilized Gemini as an expert pair-programmer to architect and debug a Laravel-based Quiz application. The system implements a 5-table relational database (Quizzes, Questions, Options, Attempts, Answers) as suggested in the technical requirements.

## 2. Key Challenges & AI-Driven Solutions
* **Environment-Specific Crashes**: Encountered a `ReflectionProperty::isVirtual()` 500 error in the local PHP environment during POST requests.
    * **AI Solution**: Identified a Symfony VarDumper version mismatch and provided a workaround by clearing application caches and refining the Controller namespaces.
* **Dynamic Evaluation Logic**: Implementing a scoring engine that handles 5 distinct question types without hardcoded logic.
    * **AI Solution**: Assisted in developing a "Type-Agnostic" evaluation system. Using `array_diff` and `trim(strtolower())`, the AI helped ensure that Multiple Choice arrays and Text inputs are graded accurately regardless of spacing or casing.
* **Media Integration & Local Storage**: Managing image uploads and YouTube embeds within the Question Editor.
    * **AI Solution**: Provided the logic for storing files in the `public` disk and suggested the `str_replace` logic to convert standard YouTube links into functional `embed` URLs for Blade iframes.
* **Checkbox Data Handling**: Resolving an issue where Multiple Choice questions acted as radio buttons.
    * **AI Solution**: Guided the refactoring of the Blade view to use array-naming conventions (`name="question_id[]"`) and updated the Controller to process these arrays into a flattened string for database persistence.

## 3. Key Prompts Used
* "Create a Laravel migration for a quiz system with attempts and answers based on a 5-table relational structure."
* "How do I handle checkbox arrays in a Laravel controller submit function to award marks dynamically?"
* "Fix the ReflectionProperty::isVirtual() error occurring in a Laravel 11 environment."
* "Generate a Blade view for quiz results that displays a dynamic score out of total possible marks."

## 4. AI Corrections & Iterations
* **Initial Schema**: AI originally suggested a 3-table schema; I corrected this to follow the mandatory 5-table structure required by the assignment PDF.
* **Scoring Bug**: Corrected a logical error where the system initially returned 5/10 marks by implementing a more robust string-matching and array-comparison logic suggested by the AI.

## 5. Final Outcome
The application successfully supports all 5 required question types (Binary, Single, Multiple, Number, Text) with a dynamic scoring engine, rich text/HTML support, and media integration.
