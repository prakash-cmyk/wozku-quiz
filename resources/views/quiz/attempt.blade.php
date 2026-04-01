This is the final, corrected version of your attempt.blade.php. It now correctly distinguishes between Single Choice (radio buttons) and Multiple Choice (checkboxes with array support), which is a mandatory requirement for your submission.The Final resources/views/quiz/attempt.blade.phpHTML<div style="max-width: 700px; margin: auto; font-family: sans-serif; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
    <h1>Attempting: {{ $quiz->title }}</h1>
    <p style="color: #666;">{{ $quiz->description }}</p>
    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

    <form action="/quiz/{{ $quiz->id }}/submit" method="POST">
        @csrf
        @foreach($questions as $index => $question)
            <div style="margin-bottom: 30px; padding: 20px; border: 1px solid #e1e1e1; border-radius: 5px; background: #fafafa;">
                <h3 style="margin-top: 0; color: #2c3e50;">Q{{ $index + 1 }}: {{ $question->question_text }}</h3>
                
                <p style="font-size: 0.85em; color: #888; text-transform: uppercase; margin-bottom: 15px;">
                    Type: {{ $question->type }}
                </p>

                @if($question->type == 'text' || $question->type == 'number')
                    <input type="{{ $question->type }}" 
                           name="question_{{ $question->id }}" 
                           required 
                           style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                
                @elseif($question->type == 'multiple')
                    <p style="font-size: 0.9em; color: #d9534f; margin-bottom: 10px;">(Select all that apply)</p>
                    @foreach($question->options as $option)
                        <label style="display: block; margin: 12px 0; cursor: pointer; background: white; padding: 10px; border-radius: 4px; border: 1px solid #ddd;">
                            <input type="checkbox" name="question_{{ $question->id }}[]" value="{{ $option->option_text }}">
                            <span style="margin-left: 8px;">{{ $option->option_text }}</span>
                        </label>
                    @endforeach

                @else
                    @foreach($question->options as $option)
                        <label style="display: block; margin: 12px 0; cursor: pointer; background: white; padding: 10px; border-radius: 4px; border: 1px solid #ddd;">
                            <input type="radio" name="question_{{ $question->id }}" value="{{ $option->option_text }}" required>
                            <span style="margin-left: 8px;">{{ $option->option_text }}</span>
                        </label>
                    @endforeach
                @endif
            </div>
        @endforeach

        <div style="text-align: center; margin-top: 40px;">
            <button type="submit" style="padding: 15px 40px; background: #28a745; color: white; border: none; border-radius: 5px; font-size: 1.2em; font-weight: bold; cursor: pointer; transition: background 0.3s;">
                Submit Quiz
            </button>
            <br><br>
            <a href="/quizzes" style="color: #666; text-decoration: none;">Cancel and Return to Dashboard</a>
        </div>
    </form>
</div>