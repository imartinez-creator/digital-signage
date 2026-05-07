<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Gestor Digital Signage')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f4f4;
            color: #222;
        }

        header {
            background: #1f2937;
            color: white;
            padding: 16px 32px;
        }

        nav {
            background: #111827;
            padding: 12px 32px;
        }

        nav a {
            color: white;
            margin-right: 20px;
            text-decoration: none;
            font-weight: bold;
        }

        main {
            padding: 32px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #e5e7eb;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border: 0;
            border-radius: 4px;
            cursor: pointer;
            margin: 2px;
        }

        .btn-danger {
            background: #dc2626;
        }

        .btn-secondary {
            background: #4b5563;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 6px;
            max-width: 900px;
        }

        label {
            display: block;
            margin-top: 16px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="url"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            box-sizing: border-box;
        }

        textarea {
            min-height: 120px;
        }

        .success {
            padding: 12px;
            background: #dcfce7;
            border: 1px solid #16a34a;
            margin-bottom: 16px;
        }

        .errors {
            padding: 12px;
            background: #fee2e2;
            border: 1px solid #dc2626;
            margin-bottom: 16px;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            background: #e5e7eb;
            display: inline-block;
            margin: 2px;
        }

        .badge-green {
            background: #bbf7d0;
        }

        .badge-red {
            background: #fecaca;
        }

        .badge-yellow {
            background: #fef08a;
        }
    </style>
</head>
<body>
<header>
    <h1>Gestor Digital Signage - Edifici H</h1>
</header>

<nav>
    <a href="{{ route('slides.index') }}">Diapositives manuals</a>
    <a href="{{ route('screens.index') }}">Pantalles</a>
</nav>

<main>
    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="errors">
            <strong>Hi ha errors al formulari:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>


