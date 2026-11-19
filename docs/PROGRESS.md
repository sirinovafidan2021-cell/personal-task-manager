# İcra vəziyyəti

## Bərpa edilmiş vəziyyət

2026-11-19 tarixində kəsilmiş sessiyanın kodu, migration statusu, DB connection, route-lar və testlər faktiki yoxlanıldı. Əvvəlki progress sənədi backend/auth/frontend-in başlamadığını deyirdi, lakin kodda həmin modullar artıq qismən tamamlanmışdı. Bu sənəd real vəziyyətə əsasən yenilənib.

## Mərhələlər

- **COMPLETED — Audit və plan:** `Architecture.md` tam oxunub; Laravel 12.73, Apiato 13.2.1, Passport 13.12.0 və Porto route discovery təsdiqlənib.
- **COMPLETED — Database və Task backend:** tasks migration, Eloquent əlaqələri, API CRUD, filter, ownership və transformer tamamlanıb.
- **COMPLETED — WEB autentifikasiya:** qeydiyyat, session login, Password Grant token sessiyası, refresh lock və token revocation logout tamamlanıb.
- **COMPLETED — Blade/Fetch UI:** list/create/edit view-ları və Vanilla Fetch CRUD tamamlanıb.
- **COMPLETED — Seed, test və təhvil materialları:** idempotent development seeder, fokus testləri, Postman, README və modul sənədləri hazırlanıb.
- **COMPLETED — İkinci arxitektura auditı:** 42 tələb qrupu yenidən kodla müqayisə edildi; API origin/CORS, Blade namespace, invalid hash-id və User constraint uyğunsuzluqları düzəldildi.
- **IN PROGRESS — Yekun cross-platform verifikasiya:** aktiv MySQL serveri olmadığı üçün MySQL schema və tam upstream suite həmin connection-da yoxlanılmayıb.

## Faktiki yoxlamalar

- `php artisan migrate:status`: PASS; `2026_11_19_000000_create_tasks_table` işlənib.
- `php artisan apiato:seed-deploy` iki dəfə: PASS; seed user sayı 2, task sayı 6, duplicate yoxdur.
- `php artisan task-manager:passport-client`: PASS; lokal Passport keys və confidential Password Grant client provision edilib, secret göstərilməyib.
- Task functional suite: PASS, 4 test / 30 assertion.
- WEB register + token lifecycle suite: PASS, 2 test / 22 assertion.
- Login/logout/task focus suite: PASS, 7 test / 38 assertion; 1 mövcud remember-cookie test intentional incomplete-dir.
- Son birləşdirilmiş TaskManagement + Authentication WEB fokus paketi: PASS, 10 test / 72 assertion; 1 əvvəlcədən mövcud intentional incomplete remember-cookie testi.
- `npm run build`: PASS.
- TaskManagement ikinci audit fokus paketi: PASS, 5 test / 37 assertion.
- Authentication WEB paketi: PASS, 5 test / 33 assertion və 1 intentional incomplete legacy test.
- Tam `php artisan test`: 346 keçdi, 27 failed, 1 incomplete. Ətraflı səbəblər `Testing.md`-dədir; testlər dəyişdirilərək gizlədilməyib.

## Məlum məhdudiyyətlər və növbəti addımlar

- **BLOCKED:** Aktiv environment SQLite-dir. Arxitekturada hədəflənən MySQL/InnoDB/utf8mb4 connection və səlahiyyət verilmədiyi üçün həmin serverdə migration/index/FK və tam suite yoxlanılmayıb.
- **IN PROGRESS:** Mövcud upstream Apiato testlərinin SQLite tip expectation-ları platforma-uyğunlaşdırılmalıdır; bu task modulundan kənar şablon uyğunsuzluğudur və kor-koranə test dəyişdirilməyib.
- **COMPLETED:** Browser üçün refresh token və client secret exposure-u yoxdur. Legacy API web-client endpoint-ləri browser task UI tərəfindən istifadə olunmur.
- **COMPLETED:** `/tasks` real view render, API_URL origin və minimum CORS origin testlə yoxlanıb.
- **COMPLETED:** Lokal `artisan serve` inteqrasiyası üçün API route-domain və browser base URL ayrıldı; detal `Local_Web_API_Integration.md` faylındadır.
- **COMPLETED:** `task-manager.js`-də qalan WEB naviqasiya URL-ləri Blade named route-larından ötürülür; sabit hostname və WEB route URL-si yoxdur.
- **BLOCKED (mühit):** `php artisan serve --host=127.0.0.1 --port=8000` bu sandbox-da `Failed to listen` nəticəsi verdi. Bu, kod failure-u deyil; real browser/curl smoke testi lokal maşında aparılmalıdır.

## Əsas yaradılmış/dəyişdirilmiş fayllar

- `app/Containers/AppSection/TaskManagement/**`
- `app/Containers/AppSection/TaskManagement/Data/Migrations/2026_11_19_000001_require_task_manager_user_credentials.php`
- `app/Containers/AppSection/User/Models/User.php`
- `app/Containers/AppSection/Authentication/Actions/Web/**`, `Tasks/WebTokenSessionTask.php`, WEB request/controller/route/view faylları
- `app/Ship/Commands/ConfigureTaskManagerPassport.php`, `app/Ship/Seeders/*`
- `resources/js/task-manager.js`, `vite.config.js`, `phpunit.xml`, `README.md`
- `postman/Personal_Task_Manager.*.json`, `docs/*.md` (o cümlədən `ARCHITECTURE_COMPLIANCE_REVIEW.md`, `Local_Web_API_Integration.md`)
