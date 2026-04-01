# AI Usage Log - Wozku Quiz Project

## 1. Project Overview
I used AI (Gemini) as a pair-programmer to build a Laravel-based Quiz application with a 5-table relational database.

## 2. Key Challenges & AI Solutions
* **Challenge:** Encountered a `ReflectionProperty::isVirtual()` 500 error in the PHP 8.2 environment.
    * **Solution:** AI suggested using explicit namespaces for the `Request` class and wrapping controller logic in `try-catch` blocks to bypass the Symfony var-dumper crash.
* **Challenge:** Implementing Multiple Choice (Checkboxes) where answers are sent as arrays.
    * **Solution:** Refactored the `submit` logic in `QuizController` to use `is_array()` and `implode()` to store and grade multi-select data.
* **Challenge:** Database Integrity Constraints during schema migration.
    * **Solution:** Used `migrate:refresh` to synchronize the `questions` and `options` tables after adding foreign key relationships.

## 3. Prompts Used
* "Create a Laravel migration for a quiz system with attempts and answers."
* "How do I handle checkbox arrays in a Laravel controller submit function?"
* "Fix the ReflectionProperty error during a POST request."

## 4. Final Result
The application successfully supports 5 question types (Binary, MCQ, Multiple, Number, Text) with a dynamic scoring engine and persistent storage of results.