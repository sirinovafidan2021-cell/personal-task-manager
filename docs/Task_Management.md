# TaskManagement container-i

## Porto axını

Container `app/Containers/AppSection/TaskManagement` altında yerləşir. API controller-də Eloquent query yoxdur:

`Route → auth:api → Request validation → Controller → Action → Task → User::tasks() → Transformer → JSON`

`ListTasksTask`, `FindTaskForUserTask`, `CreateTaskTask`, `UpdateTaskTask`, `DeleteTaskTask` kiçik, təkrar istifadə edilə bilən əməliyyatları ayırır. Action-lar use-case koordinasiyasını edir.

## Sahiblik və validasiya

`FindTaskForUserTask` heç vaxt qlobal `Task::find()` istifadə etmir: `$user->tasks()->findOrFail($taskId)` çağırır. Bu, başqa user-in ID-si üçün 404 qaytarır və resursun mövcudluğunu açıqlamır.

`CreateTaskRequest` title üçün required/string/max:150, description üçün nullable/string, is_completed üçün boolean tətbiq edir; `user_id` `prohibited`-dır. `UpdateTaskRequest` yalnız `sometimes` sahələrini qəbul edir və boş PATCH üçün 422 qaytarır. `ListTasksRequest` yalnız `all`, `completed`, `pending` filter-lərini qəbul edir; naməlum filter 422-dir.

`TaskTransformer` eyni response formatında id, title, description, is_completed və ISO tarixlərini qaytarır. Apiato hash-id aktiv olduğu üçün response `id` hash-lənir və frontend həmin ID-ni yenidən route-a verir.
