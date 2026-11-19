# Personal Task Manager

Apiato 13 və Porto Architecture əsasında qurulmuş şəxsi tapşırıq idarəetmə tətbiqidir. WEB hissəsi Blade və Vanilla JavaScript istifadə edir; bütün tapşırıq dəyişiklikləri Passport ilə qorunan REST API-yə Fetch API sorğuları vasitəsilə edilir.

Ətraflı Azərbaycan dilində texniki sənədlər [`docs/`](docs/) qovluğundadır.

## Tələblər

- PHP 8.4+ və Composer
- Node.js 20+ və npm
- Laravel 12, Apiato 13 və Passport (Composer ilə artıq quraşdırılıb)
- İnkişaf üçün SQLite; production üçün MySQL 8+/MariaDB, InnoDB və `utf8mb4`

## Lokal quraşdırma

```bash
composer install
cp .env.example .env
php artisan key:generate
```

SQLite istifadə edilirsə, `.env` daxilində aşağıdakı dəyər verilməlidir:

```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

`php artisan serve` ilə eyni-origin WEB/API işlətmək üçün URL dəyərlərini də belə saxlayın:

```dotenv
APP_URL=http://127.0.0.1:8000
# Apiato bunu Route::domain() hostu kimi istifadə edir; burada port olmamalıdır.
API_URL=http://127.0.0.1
FRONTEND_URL="${APP_URL}"
SESSION_DOMAIN=null
```

Task səhifəsi API ünvanını named route və `APP_URL` əsasında yaradır; JavaScript-də hostname sabit yazılmayıb. Buna görə sorğu `http://127.0.0.1:8000/v1/tasks?filter=all` ünvanına gedir. `api.apiato.test` üçün hosts/DNS qeydi yaratmaq lazım deyil.

MySQL istifadə edilirsə, `DB_CONNECTION=mysql` və səlahiyyətli `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` dəyərlərini təyin edin. MySQL verilənlər bazasını yalnız uyğun səlahiyyətlə özünüz yaradın; tətbiq heç vaxt onu silmir.

Sonra təhlükəsiz, artımlı migration-ları işlədin:

```bash
php artisan migrate
php artisan task-manager:passport-client
php artisan apiato:seed-deploy
npm install
npm run build
```

`task-manager:passport-client` Passport açarlarını lazım olduqda yaradır, Password Grant client yaradır və onun ID/secret dəyərlərini yalnız lokal `.env` faylına yazır. Secret ekrana çıxarılmır, Git-ə əlavə edilmir və heç vaxt browser-ə göndərilmir. Mövcud aktiv client varsa komanda heç nəyi dəyişmir.

İnkişaf serveri:

```bash
php artisan optimize:clear
npm run build
php artisan serve --host=127.0.0.1 --port=8000 --no-reload
```

Brauzerdə `http://127.0.0.1:8000/login` açın.

## Lokal nümunə hesabları

`APP_ENV=production` olmadıqda `apiato:seed-deploy` aşağıdakı idempotent məlumatları yaradır:

| E-poçt | Parol | Tapşırıq sayı |
| --- | --- | ---: |
| `user1@example.com` | `password` | 3 |
| `user2@example.com` | `password` | 3 |

Bu hesablar yalnız lokal development/test üçündür. Production-da seeder nümunə məlumat yaratmır.

## WEB route-ları

| Method | URL | Giriş |
| --- | --- | --- |
| GET/POST | `/register` | qonaq |
| GET/POST | `/login` | qonaq |
| POST | `/logout` | `auth:web`, CSRF |
| GET | `/tasks` | `auth:web` |
| GET | `/tasks/create` | `auth:web` |
| GET | `/tasks/{id}/edit` | `auth:web` |
| POST | `/tasks/token/refresh` | `auth:web`, CSRF |

## API endpoint-ləri

Bütün endpoint-lər Passport `auth:api` middleware-i ilə qorunur. İdentifikatorlar Apiato hash-id konfiqurasiyası aktiv olduqda hash-lənmiş formatdadır.

| Method | URL | Təyinat |
| --- | --- | --- |
| GET | `/v1/tasks?filter=all|completed|pending` | şəxsi siyahı |
| GET | `/v1/tasks/{id}` | bir tapşırıq |
| POST | `/v1/tasks` | yaratmaq |
| PATCH | `/v1/tasks/{id}` | qismən yeniləmək/tamamlamaq |
| DELETE | `/v1/tasks/{id}` | silmək |

Create JSON nümunəsi:

```json
{"title":"Dərs oxumaq","description":"Passport mövzusunu təkrar et","is_completed":false}
```

`user_id` request body-də qəbul edilmir. Başqa istifadəçiyə məxsus tapşırıq GET/PATCH/DELETE üçün 404 cavabı verir.

## Token axını

1. WEB login `web` guard ilə etimadnaməni yoxlayır və session ID-ni yeniləyir.
2. Server Password Grant vasitəsilə Passport access/refresh token alır.
3. Access token, refresh token, expiry və access-token ID yalnız server-side session-da saxlanır.
4. Cari Blade səhifəsi yalnız access tokeni təhlükəsiz JSON ilə JavaScript yaddaşına ötürür. Refresh token və client secret browser-ə verilmir.
5. Fetch sorğusu `Authorization: Bearer` ilə `/v1/tasks` API-sinə gedir. 401 cavabında `/tasks/token/refresh` endpoint-i CSRF ilə bir dəfə çağırılır və sorğu maksimum bir dəfə təkrar edilir.
6. Logout cari access token və onun refresh tokenlərini ləğv edir, sonra session-ı invalidasiya edir.

Köhnə Apiato web-client API endpoint-ləri ayrı API istehlakçıları üçündür; browser task axını onlardan istifadə etmir, çünki onlar refresh tokeni response body-yə qoya bilər.

## Test və keyfiyyət

```bash
php artisan test app/Containers/AppSection/TaskManagement/Tests/Functional
php artisan test app/Containers/AppSection/Authentication/Tests/Functional/WEB
npm run build
```

`phpunit.xml` testləri izolyasiya edilmiş `:memory:` SQLite ilə işlədir; development DB-yə qarşı test işlədilmir. Tam paketdə mövcud vendor şablon testlərinin SQLite tip fərqləri ilə bağlı bilinən nasazlıqları var; dəqiq nəticələr [`docs/Testing.md`](docs/Testing.md) faylındadır.

Postman faylları: [`postman/Personal_Task_Manager.postman_collection.json`](postman/Personal_Task_Manager.postman_collection.json) və [`postman/Personal_Task_Manager.local.postman_environment.json`](postman/Personal_Task_Manager.local.postman_environment.json). Environment yalnız placeholder istifadə edir; real secret və parol daxil deyil.

## Faydalı mənbələr

- [Laravel 12](https://laravel.com/docs/12.x)
- [Laravel Passport](https://laravel.com/docs/12.x/passport)
- [Apiato](https://apiato.io/docs/)
- [MDN Fetch API](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API)
- [MDN HTTP](https://developer.mozilla.org/en-US/docs/Web/HTTP)
- [MySQL sənədləri](https://dev.mysql.com/doc/)
