let config = window.taskManagerConfig;

const status = (element, message, isError = false) => {
    if (!element) return;
    element.textContent = message;
    element.className = `mb-4 ${isError ? 'text-red-700' : 'text-slate-600'}`;
};

const refreshAccessToken = async () => {
    const response = await fetch(config.refreshUrl, {
        method: 'POST', credentials: 'same-origin',
        headers: {'Accept': 'application/json', 'X-CSRF-TOKEN': config.csrfToken},
    });
    if (!response.ok) throw new Error('Session refresh failed');
    const payload = await response.json();
    config.accessToken = payload.access_token;
};

const api = async (path = '', options = {}, retried = false) => {
    const headers = new Headers(options.headers || {});
    headers.set('Accept', 'application/json');
    headers.set('Authorization', `Bearer ${config.accessToken}`);
    const response = await fetch(`${config.apiBaseUrl}${path}`, {...options, headers});
    if (response.status === 401 && !retried) {
        try { await refreshAccessToken(); return api(path, options, true); }
        catch (_) { window.location.assign(config.loginUrl); throw _; }
    }
    return response;
};

const readJson = async (response) => response.status === 204 ? null : response.json();

const displayErrors = (container, errors = {}) => {
    container.querySelectorAll('.field-error').forEach((element) => { element.textContent = ''; });
    Object.entries(errors).forEach(([field, messages]) => {
        const target = container.querySelector(`[data-field="${field}"]`);
        if (target) target.textContent = messages[0];
    });
};

const setupIndex = () => {
    const list = document.querySelector('#task-list');
    if (!list) return;
    const message = document.querySelector('#task-status');
    let currentFilter = 'all';
    const load = async () => {
        status(message, 'Yüklənir…'); list.replaceChildren();
        try {
            const response = await api(`?filter=${encodeURIComponent(currentFilter)}`);
            const payload = await readJson(response);
            if (!response.ok) throw new Error(payload.message || 'Tapşırıqlar yüklənmədi.');
            const tasks = payload.data || [];
            if (!tasks.length) { status(message, 'Bu filtr üçün tapşırıq yoxdur.'); return; }
            status(message, `${tasks.length} tapşırıq göstərilir.`);
            tasks.forEach((task) => {
                const item = document.createElement('li'); item.className = 'rounded bg-white p-4 shadow';
                const heading = document.createElement('a'); heading.href = config.tasksEditUrlTemplate.replace('__TASK_ID__', encodeURIComponent(task.id)); heading.textContent = task.title; heading.className = 'font-semibold text-indigo-700';
                const description = document.createElement('p'); description.textContent = task.description || 'Təsvir yoxdur'; description.className = 'mt-1 text-sm text-slate-600';
                const controls = document.createElement('div'); controls.className = 'mt-3 flex items-center gap-3';
                const toggle = document.createElement('button'); toggle.type = 'button'; toggle.textContent = task.is_completed ? 'Gözləyən et' : 'Tamamla'; toggle.className = 'rounded border px-3 py-1';
                toggle.addEventListener('click', async () => { toggle.disabled = true; await api(`/${encodeURIComponent(task.id)}`, {method: 'PATCH', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({is_completed: !task.is_completed})}); await load(); });
                const remove = document.createElement('button'); remove.type = 'button'; remove.textContent = 'Sil'; remove.className = 'rounded border border-red-700 px-3 py-1 text-red-700';
                remove.addEventListener('click', async () => { if (!window.confirm('Bu tapşırıq silinsin?')) return; remove.disabled = true; const response = await api(`/${encodeURIComponent(task.id)}`, {method: 'DELETE'}); if (!response.ok) { status(message, 'Silmək mümkün olmadı.', true); remove.disabled = false; return; } await load(); });
                controls.append(toggle, remove); item.append(heading, description, controls); list.append(item);
            });
        } catch (_) { status(message, 'Şəbəkə və ya server xətası. Yenidən cəhd edin.', true); }
    };
    document.querySelectorAll('.task-filter').forEach((button) => button.addEventListener('click', () => { currentFilter = button.dataset.filter; load(); }));
    load();
};

const setupForm = () => {
    const form = document.querySelector('#task-form');
    if (!form) return;
    const taskId = form.dataset.taskId;
    const message = document.querySelector('#form-status');
    const button = document.querySelector('#task-submit');
    const title = form.elements.title; const description = form.elements.description; const completed = form.elements.is_completed;
    const populate = async () => {
        if (!taskId) return;
        try { const response = await api(`/${encodeURIComponent(taskId)}`); const payload = await readJson(response); if (!response.ok) throw new Error(); title.value = payload.data.title; description.value = payload.data.description || ''; completed.checked = payload.data.is_completed; }
        catch (_) { status(message, 'Tapşırıq yüklənmədi.', true); button.disabled = true; }
    };
    form.addEventListener('submit', async (event) => {
        event.preventDefault(); button.disabled = true; displayErrors(form); status(message, 'Yadda saxlanılır…');
        const body = {title: title.value, description: description.value || null, is_completed: completed.checked};
        try { const response = await api(taskId ? `/${encodeURIComponent(taskId)}` : '', {method: taskId ? 'PATCH' : 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(body)}); const payload = await readJson(response); if (response.status === 422) { displayErrors(form, payload.errors); status(message, 'Məlumatları yoxlayın.', true); return; } if (!response.ok) throw new Error(); window.location.assign(config.tasksIndexUrl); }
        catch (_) { status(message, 'Saxlama zamanı xəta baş verdi. Yenidən cəhd edin.', true); }
        finally { button.disabled = false; }
    });
    populate();
};

document.addEventListener('DOMContentLoaded', () => { config = window.taskManagerConfig; if (!config) return; setupIndex(); setupForm(); });
