<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>
<body>
    <h1>This is a PDF document</h1>
    <p>Generated using Laravel.</p>
    <h2>Dynamic Data:</h2>
    <ul>
        @foreach($product as $key => $value)
            <li><strong>{{ $key }}:</strong> {{ $value }}</li>
        @endforeach
    </ul>
</body>
</html>
