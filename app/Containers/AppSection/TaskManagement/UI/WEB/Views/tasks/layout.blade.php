<!doctype html>
<html lang="az">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tapşırıqlar') — Personal Task Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/task-manager.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
<main class="mx-auto max-w-3xl px-4 py-8 sm:py-12">
    <header class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <a class="text-xl font-bold text-indigo-700" href="{{ route('tasks.index') }}">Personal Task Manager</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="rounded bg-slate-800 px-4 py-2 text-sm font-medium text-white" type="submit">Çıxış</button>
        </form>
    </header>
    @yield('content')
</main>
<script>
    window.taskManagerConfig = {{ Illuminate\Support\Js::from([
        'accessToken' => $accessToken,
        'apiBaseUrl' => $apiBaseUrl,
        'refreshUrl' => route('tasks.token.refresh'),
        'loginUrl' => route('login.form'),
        'tasksIndexUrl' => route('tasks.index'),
        'tasksEditUrlTemplate' => route('tasks.edit', ['task_id' => '__TASK_ID__']),
        'csrfToken' => csrf_token(),
    ]) }};
</script>
</body>
</html>
