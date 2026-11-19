# Lokal WEB və API inteqrasiyası

## Səbəb

Brauzer `http://api.apiato.test/v1/tasks` ünvanına getməyə çalışırdı. Bu hostname lokal DNS/hosts faylında müəyyən edilmədiyi üçün `ERR_NAME_NOT_RESOLVED` yaranırdı.

Apiato 13-də `app/Ship/Configs/apiato.php` daxilindəki `api.url` dəyəri `Route::domain()`-a birbaşa verilir. Buna görə `API_URL=http://127.0.0.1:8000` portlu URL kimi istifadə ediləndə route domain və URL generator portu iki dəfə emal edə, testdə malformed host yarada bilər.

## Tətbiq edilmiş local konfiqurasiya

`.env` üçün düzgün dəyərlər:

```dotenv
APP_URL=http://127.0.0.1:8000
API_URL=http://127.0.0.1
FRONTEND_URL="${APP_URL}"
SESSION_DOMAIN=null
```

`API_URL` yalnız Apiato route hostudur; port `APP_URL`-da qalır. `TasksPageController` və `TaskFormPageController` API base URL-ni `url('/v1/tasks')` ilə yaradır. Bu Laravel-in `APP_URL` dəyərindən `http://127.0.0.1:8000/v1/tasks` düzəldir. `layout.blade.php` login, refresh, task siyahısı və edit ünvanlarını named route-lardan `window.taskManagerConfig`-ə verir; JavaScript-də host və WEB naviqasiya URL-si hardcode edilməyib.

`config/cors.php` yalnız `FRONTEND_URL` origin-i qəbul edir. Local quruluşda WEB və API eyni origin olduğundan CORS preflight lazım deyil, lakin konfiqurasiya fərqli origin deployment-ləri üçün ən dar icazəni saxlayır.

## Passport və refresh axını

`PasswordTokenFactory` HTTP client istifadə etmir. O, Passport `AuthorizationServer`-i birbaşa PHP daxilində çağırır. Buna görə `php artisan serve --host=127.0.0.1 --port=8000` bir worker ilə işlədikdə login və refresh token prosesləri öz serverinə bloklayan HTTP sorğusu açmır.

Frontend yalnız API CRUD üçün `/v1/tasks`-ə Bearer tokenlə Fetch göndərir. 401 olduqda eyni-origin `/tasks/token/refresh` endpoint-i session-dakı refresh tokenlə server tərəfdə token yeniləyir. Refresh token və client secret browser-ə ötürülmür.

## Yoxlama

- `php artisan route:list --path=v1/tasks --json` bütün Task API route-larının domain-inin `127.0.0.1` olduğunu göstərir.
- Birgə TaskManagement və WEB autentifikasiya paketi: **10 keçdi, 72 assertion**; həmin paketdə qeydiyyat, login, CRUD, filter, ownership, access token, refresh və logout/revocation yoxlanır.
- Yalnız mövcud intentional incomplete remember-cookie testi qalıb; bu inteqrasiya dəyişiklikləri ilə bağlı deyil.
- `npm run build`: keçdi.

Bu avtomatlaşdırılmış iş mühitində TCP listener açmağa sandbox icazə vermədiyi üçün real browser/curl server testi edilə bilmədi. Lokal maşında aşağıdakı əmrlərlə yoxlanmalıdır.

```bash
php artisan optimize:clear
npm run build
php artisan serve --host=127.0.0.1 --port=8000 --no-reload
```

`--no-reload` `.env`-dəki `PHP_CLI_SERVER_WORKERS` ilə PHP development server-inin verdiyi xəbərdarlığı aradan qaldırır. Sonra browser-də `http://127.0.0.1:8000/login` açın, seed user ilə daxil olun və `/tasks` səhifəsində DevTools Network bölməsində `http://127.0.0.1:8000/v1/tasks?filter=all` sorğusunu təsdiqləyin.
