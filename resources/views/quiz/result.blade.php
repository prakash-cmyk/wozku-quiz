<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card shadow-lg p-5">
                    <h1 class="display-4 text-success mb-4">Quiz Completed!</h1>
                    <div class="mb-4">
                        <h2 class="h4 text-muted">Your Final Score</h2>
                        <div class="display-1 fw-bold text-primary">{{ $score }} / {{ $total }}</div>
                        <p class="mt-2 text-secondary">Marks based on question weights.</p>
                    </div>

                    <div class="progress mb-4" style="height: 30px;">
                        @php $percentage = ($score / $total) * 100; @endphp
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                             role="progressbar" 
                             style="width: {{ $percentage }}%" 
                             aria-valuenow="{{ $percentage }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                             {{ round($percentage) }}%
                        </div>
                    </div>

                    <a href="{{ route('quiz.index') }}" class="btn btn-outline-primary btn-lg">Back to All Quizzes</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>