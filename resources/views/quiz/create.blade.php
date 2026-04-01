<form action="{{ route('quiz.store') }}" method="POST">
    @csrf 
    
    <div>
        <label>Quiz Title:</label><br>
        <input type="text" name="title" required>
    </div>
    <br>
    <div>
        <label>Description:</label><br>
        <textarea name="description"></textarea>
    </div>
    <br>
    <button type="submit">Create Quiz</button>
</form>