<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wozku - Quiz Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; margin: 0; padding: 40px; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; margin-top: 0; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #34495e; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; vertical-align: middle; }
        tr:hover { background-color: #f9f9f9; }

        /* Action Buttons Styling */
        .actions-cell { display: flex; gap: 10px; }
        
        .btn { text-decoration: none; font-weight: bold; padding: 6px 12px; border-radius: 4px; font-size: 0.85em; transition: 0.3s; display: inline-block; }
        
        .btn-add { color: #3498db; border: 1px solid #3498db; }
        .btn-add:hover { background-color: #3498db; color: white; }
        
        .btn-take { color: #27ae60; border: 1px solid #27ae60; }
        .btn-take:hover { background-color: #27ae60; color: white; }

        .btn-create { display: inline-block; margin-top: 25px; padding: 12px 25px; background-color: #27ae60; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; transition: background 0.3s; }
        .btn-create:hover { background-color: #219150; }
        
        .alert-success { background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

<div class="container">
    <h2>Wozku Quiz Dashboard</h2>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Quiz Title</th>
                <th>Description</th>
                <th style="width: 250px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quizzes as $quiz)
            <tr>
                <td>{{ $quiz->id }}</td>
                <td><strong>{{ $quiz->title }}</strong></td>
                <td>{{ $quiz->description }}</td>
                <td>
                    <div class="actions-cell">
                        <a href="/quiz/{{ $quiz->id }}/questions/create" class="btn btn-add">+ Add Questions</a>
                        
                        <a href="/quiz/{{ $quiz->id }}/attempt" class="btn btn-take">▶ Take Quiz</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="/quiz/create" class="btn-create">Create New Quiz</a>
</div>

</body>
</html>