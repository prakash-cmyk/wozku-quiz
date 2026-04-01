<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Question - {{ $quiz->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3>Add Question to: {{ $quiz->title }}</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('questions.store', $quiz->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">Question Text (HTML/Rich Text Supported)</label>
                        <textarea name="question_text" class="form-control" rows="3" required placeholder="e.g. <b>What</b> is Laravel?"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Question Type</label>
                            <select name="type" class="form-control" required>
                                <option value="Binary">Binary (True/False)</option>
                                <option value="Single">Single Choice (MCQ)</option>
                                <option value="Multiple">Multiple Choice (Checkboxes)</option>
                                <option value="Number">Number Input</option>
                                <option value="Text">Text Input</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Marks for this question</label>
                            <input type="number" name="marks" class="form-control" value="1" min="1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-danger"><strong>Correct Answer(s)</strong></label>
                        <input type="text" name="correct_answer" class="form-control" required placeholder="Enter the exact correct answer">
                        <small class="text-muted">Note: For 'Multiple Choice', separate answers with a comma (e.g. MySQL, SQLite).</small>
                    </div>

                    <hr>
                    <h5>Media Support (Optional)</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Upload Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">YouTube Video URL</label>
                            <input type="url" name="video_url" class="form-control" placeholder="https://www.youtube.com/watch?v=...">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">Save Question</button>
                        <a href="{{ route('quiz.index') }}" class="btn btn-secondary">Back to Quizzes</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>