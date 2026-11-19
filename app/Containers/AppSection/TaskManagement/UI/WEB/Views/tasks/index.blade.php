@extends('appSection@taskManagement::tasks.layout')

@section('title', 'Tapşırıqlar')

@section('content')
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Tapşırıqlarım</h1>
            <p class="mt-1 text-slate-600">Siyahı səhifə yenilənmədən idarə olunur.</p>
        </div>
        <a class="rounded bg-indigo-600 px-4 py-2 font-medium text-white" href="{{ route('tasks.create') }}">Yeni tapşırıq</a>
    </div>
    <div class="mb-4 flex gap-2" aria-label="Tapşırıq filtri">
        <button class="task-filter rounded border px-3 py-2" data-filter="all" type="button">Hamısı</button>
        <button class="task-filter rounded border px-3 py-2" data-filter="pending" type="button">Gözləyən</button>
        <button class="task-filter rounded border px-3 py-2" data-filter="completed" type="button">Tamamlanan</button>
    </div>
    <p id="task-status" class="mb-4" role="status" aria-live="polite">Yüklənir…</p>
    <ul id="task-list" class="space-y-3"></ul>
@endsection
