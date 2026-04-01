@if(session('success'))
    <div style="color: green; font-weight: bold; margin-bottom: 20px; padding: 10px; border: 1px solid green; background-color: #e6fffa;">
        {{ session('success') }}
    </div>
@endif

<form action="/quiz/{{ $quiz_id }}/questions/store" method="POST">
    @csrf
    <h3>Add a Question to Quiz ID: {{ $quiz_id }}</h3>
    
    <label>Question Text:</label><br>
    <textarea name="question_text" required style="width: 300px; height: 100px; padding: 10px;"></textarea>
    <br><br>

    <label>Question Type:</label><br>
    <select name="type" required style="padding: 5px; width: 325px;">
        <option value="binary">Binary (True/False)</option>
        <option value="mcq">MCQ (Single Choice)</option>
        <option value="multiple">Multiple Choice (Checkboxes)</option>
        <option value="number">Number</option>
        <option value="text">Text</option>
    </select>
    <br><br>

    <button type="submit" style="padding: 10px 20px; cursor: pointer; background-color: #4A90E2; color: white; border: none; border-radius: 4px;">
        Save Question
    </button>
</form>
<hr>
<h4>Quick Actions:</h4>
<a href="/quizzes" style="text-decoration: none; color: #666;">← Back to Dashboard</a>
<br><br>
<p style="color: #666; font-size: 0.9em;">
    <strong>Note:</strong> After saving, you can manage options for this quiz from the Dashboard.
</p>

<br><hr><br>
<a href="/quizzes" style="text-decoration: none; color: #666;">← Back to All Quizzes</a>