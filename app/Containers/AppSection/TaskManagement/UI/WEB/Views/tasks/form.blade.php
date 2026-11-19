@extends('appSection@taskManagement::tasks.layout')

@section('title', $taskId ? 'Tapşırığı redaktə et' : 'Yeni tapşırıq')

@section('content')
    <a class="text-indigo-700 underline" href="{{ route('tasks.index') }}">← Siyahıya qayıt</a>
    <h1 class="mb-6 mt-4 text-3xl font-bold">{{ $taskId ? 'Tapşırığı redaktə et' : 'Yeni tapşırıq' }}</h1>
    <form id="task-form" class="space-y-5" data-task-id="{{ $taskId }}" novalidate>
        <div>
            <label class="mb-1 block font-medium" for="title">Başlıq</label>
            <input class="w-full rounded border px-3 py-2" id="title" name="title" maxlength="150" required>
            <p class="field-error mt-1 text-sm text-red-700" data-field="title"></p>
        </div>
        <div>
            <label class="mb-1 block font-medium" for="description">Təsvir</label>
            <textarea class="w-full rounded border px-3 py-2" id="description" name="description" rows="5"></textarea>
            <p class="field-error mt-1 text-sm text-red-700" data-field="description"></p>
        </div>
        <label class="flex items-center gap-2"><input id="is_completed" name="is_completed" type="checkbox"> Tamamlanıb</label>
        <p id="form-status" role="status" aria-live="polite"></p>
        <button id="task-submit" class="rounded bg-indigo-600 px-4 py-2 font-medium text-white" type="submit">Yadda saxla</button>
    </form>
@endsection
