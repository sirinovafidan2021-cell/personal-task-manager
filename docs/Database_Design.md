# Verilənlər bazası dizaynı

## Aktiv mühit və migration vəziyyəti

Lokal `.env` hazırda `database/database.sqlite` connection-ından istifadə edir. Bu seçim mövcud layihə vəziyyətini qoruyur; migration-lar Laravel Schema API ilə yazıldığı üçün MySQL-də də işləyir. Production üçün arxitekturanın tələb etdiyi MySQL/InnoDB və `utf8mb4` connection dəyərləri `.env` vasitəsilə verilməlidir. Connection səlahiyyətləri təqdim edilmədiyindən MySQL DB yaradılması yoxlanılmayıb.

`php artisan migrate:status` nəticəsində mövcud User, Passport, authorization migration-ları və `2026_11_19_000000_create_tasks_table` işlənmişdir. Heç bir `migrate:fresh`, `db:wipe`, `DROP TABLE` və ya `TRUNCATE` əmri istifadə edilməyib.

## Tasks cədvəli

Mənbə: `app/Containers/AppSection/TaskManagement/Data/Migrations/2026_11_19_000000_create_tasks_table.php`.

| Sütun | Qayda |
| --- | --- |
| `id` | bigint primary key |
| `user_id` | məcburi foreign key → `users.id`, silinmədə cascade |
| `title` | `varchar(150)`, məcburi |
| `description` | nullable text |
| `is_completed` | boolean, default `false` |
| timestamps | `created_at`, `updated_at` |

`user_id` ayrıca indekslənir, `(user_id, is_completed)` composite indeksi filtrli siyahılama üçün yaradılır. `TaskDatabaseTest` SQLite-də indeks adlarını, foreign key `CASCADE` qaydasını, default dəyəri və Eloquent əlaqəsini yoxlayır.

Starter User migration-ı name/email/password sütunlarını nullable yaratmışdı. Arxitekturanın məcburi credential tələbinə uyğun olaraq `2026_11_19_000001_require_task_manager_user_credentials.php` migration-ı bu üç sütunu NOT NULL edir. İcradan əvvəl mövcud DB-də null dəyər sayı read-only sorğu ilə 0 təsdiqlənib; migration sonra SQLite metadata-da `notnull=1` yoxlanıb.

## Eloquent əlaqəsi

`app/Containers/AppSection/User/Models/User.php` içində `tasks(): HasMany`; `app/Containers/AppSection/TaskManagement/Models/Task.php` içində `user(): BelongsTo` var. `Task::$fillable` yalnız `title`, `description`, `is_completed` sahələrini ehtiva edir. Beləliklə `user_id` mass-assignment ilə request-dən təyin edilə bilməz.

## Seed məlumatları

`DevelopmentTaskSeeder` development/testing mühitlərində `user1@example.com` və `user2@example.com` üçün hər birinə üç tapşırıq yaradır. `firstOrCreate` həm user, həm də `(user_id,title)` task üçün istifadə olunduğuna görə təkrar icra duplicate yaratmır. Production mühitində seeder dərhal dayanır. `apiato:seed-deploy` iki dəfə işlədilərək faktiki olaraq 2 seed user və 6 seed task təsdiqlənib.
