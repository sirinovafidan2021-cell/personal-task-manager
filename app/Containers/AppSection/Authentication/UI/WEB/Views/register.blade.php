<!doctype html>
<html lang="az">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Qeydiyyat — Personal Task Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
<main class="mx-auto max-w-md px-4 py-12">
    <h1 class="mb-2 text-3xl font-bold">Hesab yarat</h1>
    <p class="mb-6 text-slate-600">Şəxsi tapşırıqlarınızı idarə etmək üçün qeydiyyatdan keçin.</p>
    <form class="space-y-4 rounded bg-white p-6 shadow" action="{{ route('register') }}" method="POST">
        @csrf
        <div><label class="mb-1 block font-medium" for="name">Ad</label><input class="w-full rounded border px-3 py-2" id="name" name="name" value="{{ old('name') }}" required autofocus>@error('name')<p class="text-sm text-red-700">{{ $message }}</p>@enderror</div>
        <div><label class="mb-1 block font-medium" for="email">E-poçt</label><input class="w-full rounded border px-3 py-2" id="email" type="email" name="email" value="{{ old('email') }}" required>@error('email')<p class="text-sm text-red-700">{{ $message }}</p>@enderror</div>
        <div><label class="mb-1 block font-medium" for="password">Parol</label><input class="w-full rounded border px-3 py-2" id="password" type="password" name="password" required>@error('password')<p class="text-sm text-red-700">{{ $message }}</p>@enderror</div>
        <div><label class="mb-1 block font-medium" for="password_confirmation">Parolu təkrarlayın</label><input class="w-full rounded border px-3 py-2" id="password_confirmation" type="password" name="password_confirmation" required></div>
        <button class="w-full rounded bg-indigo-600 px-4 py-2 font-medium text-white" type="submit">Qeydiyyatdan keç</button>
    </form>
    <p class="mt-4 text-sm">Hesabınız var? <a class="text-indigo-700 underline" href="{{ route('login.form') }}">Daxil olun</a>.</p>
</main>
</body>
</html>
