# Project Architecture - Wozku Quiz Engine

## 1. Database Schema (Relational Model)
The application implements a robust 5-table relational structure to ensure data integrity and clear separation of concerns:
* **Quizzes**: Stores high-level metadata including title and description.
* **Questions**: Linked to Quizzes via quiz_id. It stores the question text (HTML supported), type, and weight (marks).
* **Options**: Linked to Questions via question_id. This table stores the potential answers and a boolean is_correct flag to identify the ground truth for evaluation.
* **Attempts**: Records a user's specific session, linking a user to a quiz and storing the final calculated score.
* **Answers**: Stores individual user responses linked to an attempt_id and question_id, allowing for granular review of user performance.

## 2. Technical Design Decisions
### Type-Agnostic Evaluation
To avoid hardcoded logic for each of the 5 required question types (Binary, Single, Multiple, Number, Text), the system uses a Normalized Comparison Engine. 
* **Input Normalization**: User inputs (whether strings or checkbox arrays) are converted into a consistent format using trim(strtolower()) and implode().
* **Set Theory Matching**: For Multiple Choice questions, the engine uses array_diff to ensure the user's selection exactly matches the set of correct options in the database, preventing partial credit unless configured.

### Media & Rich Text Support
* **Storage**: Images are handled via Laravel's Storage facade, utilizing the public disk for local persistence.
* **Video**: The system dynamically transforms standard YouTube URLs into embed format to ensure compatibility with Blade-rendered iframes.

## 3. Data Flow & Evaluation Logic
1. **Fetch**: The attempt method retrieves questions and associated options via the DB Query Builder to minimize overhead.
2. **Process**: Upon submission, the submit method iterates through the Request object, identifying the question type and marks associated with each ID.
3. **Score**: The system dynamically sums the marks for every is_correct match, updating the attempts table in real-time.
4. **Result**: A dedicated result view calculates the percentage and displays the final score out of the total possible marks.

## 4. Extensibility
The architecture is designed for future growth. Because the evaluation logic relies on comparing "User Input" vs "Correct Option Text" rather than hardcoded logic blocks, new question types (such as 'Matching' or 'Ordering') can be added simply by updating the Frontend Blade views and adding the corresponding rows to the options table.
