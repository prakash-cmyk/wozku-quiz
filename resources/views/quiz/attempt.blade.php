To ensure your quiz handles Multiple Choice (checkboxes) correctly  and avoids the "radio button" behavior seen in your screenshot, we need to fix the logic for how options are displayed.The critical fix is adding a secondary check to see if a question has multiple options. If it does, we must display them as a list so the user can select more than one.Corrected resources/views/quiz/attempt.blade.phpHTML<form action="{{ route('quiz.submit', $quiz->id) }}" method="POST">
    @csrf
    <h1 class="mb-4">{{ $quiz->title }}</h1>

    @foreach($questions as $question)
        <div class="card shadow-sm mb-4 p-4">
            <h4 class="mb-3">{!! $question->question_text !!} <span class="text-muted">({{ $question->marks }} Marks)</span></h4>

            {{-- Media Support: Image [cite: 22, 25] --}}
            @if($question->image_path)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $question->image_path) }}" style="max-width:400px; height:auto; border-radius: 8px;" class="img-fluid border">
                </div>
            @endif

            {{-- Media Support: YouTube Video  --}}
            @if($question->video_url)
                <div class="video-container mb-3 shadow-sm" style="border-radius: 8px; overflow: hidden;">
                    <iframe width="100%" height="315" 
                        src="{{ str_contains($question->video_url, 'embed') ? $question->video_url : str_replace('watch?v=', 'embed/', $question->video_url) }}" 
                        frameborder="0" allowfullscreen>
                    </iframe>
                </div>
            @endif

            <div class="options-container mt-3">
                @if($question->type == 'Multiple')
                    {{-- Multiple Choice Logic: Uses Checkboxes with Array Names [] [cite: 17] --}}
                    @php 
                        // Split the stored correct answer string into an array for display
                        $options = explode(', ', $question->options->first()->option_text ?? ''); 
                    @endphp
                    @foreach($options as $option)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="question_{{ $question->id }}[]" value="{{ trim($option) }}" id="q{{ $question->id }}_{{ $loop->index }}">
                            <label class="form-check-label" for="q{{ $question->id }}_{{ $loop->index }}">
                                {{ trim($option) }}
                            </label>
                        </div>
                    @endforeach

                @elseif($question->type == 'Text' || $question->type == 'Number')
                    {{-- Text/Number Logic [cite: 18, 19] --}}
                    <input type="{{ $question->type == 'Number' ? 'number' : 'text' }}" 
                           name="question_{{ $question->id }}" 
                           class="form-control" 
                           placeholder="Type your answer here...">

                @else
                    {{-- Single Choice / Binary Logic: Uses Radio Buttons [cite: 15, 16] --}}
                    @php 
                        $options = explode(', ', $question->options->first()->option_text ?? ''); 
                    @endphp
                    @foreach($options as $option)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="question_{{ $question->id }}" value="{{ trim($option) }}" id="q{{ $question->id }}_{{ $loop->index }}">
                            <label class="form-check-label" for="q{{ $question->id }}_{{ $loop->index }}">
                                {{ trim($option) }}
                            </label>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach

    <div class="mt-4 mb-5">
        <button type="submit" class="btn btn-success btn-lg px-5 shadow">Submit Quiz</button>
    </div>
</form>
