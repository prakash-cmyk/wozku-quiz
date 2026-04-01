@if(session('success'))
    <div style="color: green; padding: 10px; border: 1px solid green; background: #e6fffa; margin-bottom: 20px; border-radius: 5px;">
        {{ session('success') }}
    </div>
@endif

<div style="font-family: sans-serif; max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    <h3>Add Options for:</h3>
    <p style="font-style: italic; color: #555;">"{{ $question->question_text }}"</p>

    <form action="/question/{{ $question->id }}/options/store" method="POST">
        @csrf
        
        <label><b>Option Text:</b></label><br>
        <input type="text" name="option_text" placeholder="Enter choice text or image URL" required 
               style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">
        <br><br>

        <label style="cursor: pointer;">
            <input type="checkbox" name="is_correct" value="1"> 
            <strong>Mark as Correct Answer</strong>
        </label>
        <br><br>

        <button type="submit" style="width: 100%; padding: 12px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
            Save Option
        </button>
    </form>

    <hr style="margin: 20px 0;">
    <a href="/quizzes" style="text-decoration: none; color: #007bff;">← Back to Dashboard</a>
</div>