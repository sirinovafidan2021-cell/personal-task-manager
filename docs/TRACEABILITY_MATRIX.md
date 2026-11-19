# Tələbdən implementasiyaya izlənmə matrisi

| Arxitektura tələbi | Implementasiya | Sübut/status |
| --- | --- | --- |
| Apiato/Porto TaskManagement container | `app/Containers/AppSection/TaskManagement/**` | COMPLETED; route/action/task/model ayrıdır |
| tasks schema, FK, indeks, cascade | `Data/Migrations/2026_11_19_000000_create_tasks_table.php` | COMPLETED; `TaskDatabaseTest` PASS |
| User–Task əlaqəsi | `User.php`, `Task.php` | COMPLETED; relationship test PASS |
| REST `/v1/tasks` CRUD | `UI/API/Routes/*.v1.private.php`, controllers | COMPLETED; `TaskApiTest` PASS |
| Filter all/completed/pending, unknown 422 | `ListTasksRequest`, `ListTasksTask` | COMPLETED; `TaskApiTest` PASS |
| Request-dən user_id qəbul edilməsin | create/update request + `Task::$fillable` | COMPLETED; API test PASS |
| Başqa user taskı 404 | `FindTaskForUserTask` | COMPLETED; API test PASS |
| WEB register/login/logout | Authentication WEB request/controller/action/route | COMPLETED; WEB testlər PASS |
| Session + Password Grant | `LoginAction`, `IssueTokenAction`, `WebTokenSessionTask` | COMPLETED; lifecycle test PASS |
| Server-only refresh token/client secret | session task, `RefreshWebTokenController`, Blade config | COMPLETED; lifecycle test PASS |
| Refresh lock və bir retry | `RefreshWebTokenAction`, `resources/js/task-manager.js` | COMPLETED; code + lifecycle response test |
| Logout revocation | `RevokeWebTokenAction`, `LogoutAction` | COMPLETED; old token 401 test PASS |
| CSRF/rate limit | WEB routes and Laravel web middleware | COMPLETED; route implementation |
| Blade + Vanilla Fetch CRUD | TaskManagement WEB views, `resources/js/task-manager.js` | COMPLETED; Vite build PASS |
| Lokal eyni-origin API URL, CORS və URL generation | `TasksPageController.php`, `TaskFormPageController.php`, `layout.blade.php`, `config/cors.php`, `.env.example` | COMPLETED; API host `127.0.0.1`, browser API URL `APP_URL`-dan, `TaskWebConfigurationTest` PASS |
| Browser URL-lərinin route-dan yaradılması | `tasks/layout.blade.php`, `resources/js/task-manager.js` | COMPLETED; API, refresh, login, index və edit URL-ləri server config/named route ilə ötürülür |
| User credential NOT NULL constraint-ləri | `2026_11_19_000001_require_task_manager_user_credentials.php` | COMPLETED; metadata/database test |
| UI states / DOM safety | `task-manager.js` | COMPLETED; loading/empty/error/validation/delete confirmation; `textContent` |
| Development seeder idempotence | `DevelopmentTaskSeeder` | COMPLETED; 2 execution + test PASS |
| Postman and README | `postman/*`, `README.md` | COMPLETED |
| MySQL/InnoDB actual verification | `.env` server configuration | BLOCKED; active DB is SQLite, no MySQL credentials/server |
| Full upstream test suite | `php artisan test` | IN PROGRESS; 346 pass / 27 legacy/config SQLite-related fail / 1 incomplete |
