# İcra planı

## 1. TaskManagement backend

`tasks` cədvəli, `Task` modeli və `User::tasks()` əlaqəsi yaradılacaq. Container daxilində repository, create/list/find/update/delete action və task-ları, API request/controller/transformer faylları yerləşəcək. Bütün ID əsaslı oxuma və dəyişikliklər istifadəçinin `tasks()` əlaqəsi üzərindən aparılacaq; buna görə digər istifadəçinin resursu 404 qaytaracaq.

## 2. WEB autentifikasiya və token sessiyası

Mövcud User və Passport komponentləri yenidən istifadə ediləcək. Register action/controller/request əlavə ediləcək. Login əvvəl web guard ilə yoxlanacaq, session ID yenilənəcək, sonra Passport Password Grant tokeni server daxilində alınaraq yalnız sessiyada saxlanacaq. Refresh endpoint-i CSRF və `auth:web` ilə qorunacaq, cache lock paralel refresh-i seriallaşdıracaq. Logout cari Passport tokenlərini ləğv edəcək və session-ı bağlayacaq.

## 3. WEB UI

Blade view-lar və Vite ilə yüklənən Vanilla JavaScript yaradılacaq. Access token yalnız səhifənin JavaScript yaddaşına JSON encoding vasitəsilə ötürüləcək. Fetch wrapper 401-dən sonra maksimum bir server-side refresh və bir retry edəcək. İstifadəçi mətnləri `textContent` ilə render ediləcək.

## 4. Keyfiyyət və təhvil

Test DB-sinin izoləsi, HTTP/ownership/validation/authentication testləri, idempotent development seeder, README, Postman collection və Azərbaycan dilində modul sənədləri hazırlanacaq. Migration yalnız yeni `tasks` cədvəlini əlavə etdiyi üçün mövcud SQLite development DB-də təhlükəsiz icra edilə bilər. Passport provisioning isə secret yaratdığı və `.env` state-i dəyişdirdiyi üçün ayrıca, explicit komanda kimi təqdim olunacaq.

