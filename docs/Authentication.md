# WEB və Passport autentifikasiyası

## Konfiqurasiya

`config/auth.php`-da `web` guard session driver, `api` guard isə Passport driver istifadə edir; hər ikisi mövcud `User` provider-inə bağlıdır. `UserModel` artıq `Laravel\Passport\HasApiTokens` trait-inə malikdir. `Authentication/Providers/PassportServiceProvider.php` Password Grant-i aktivləşdirir.

`app/Ship/Commands/ConfigureTaskManagerPassport.php` lokal provisioning əməlidir. Komanda açarlar yoxdursa `passport:keys` çağırır, confidential Password Grant client yaradır və `CLIENT_WEB_ID`/`CLIENT_WEB_SECRET` dəyərlərini yalnız `.env`-ə yazır. Secret command output-da görünmür.

## WEB qeydiyyat və login

`RegisterController`/`RegisterRequest` qeydiyyat üçün name, unique email və Laravel `Password::default()` qaydasını yoxlayır. `RegisterUserAction` mövcud User create task-ını istifadə edir; model-in `hashed` cast-i parolu hash edir.

`LoginAction` aşağıdakı ardıcıllıqla işləyir:

1. `Auth::guard('web')->attempt()` email/parolu yoxlayır.
2. Session ID yenilənir.
3. `IssueTokenAction` Password Grant vasitəsilə token yaradır.
4. `WebTokenSessionTask` access token, refresh token, expiry və token ID-ni server-side session-a yazır.
5. Token alınması uğursuz olarsa web guard logout, session invalidate və CSRF token regenerate edilir; yarımçıq login saxlanmır.

`/login` və `/register` POST route-ları `guest:web` və `throttle:5,1` ilə məhdudlaşdırılır.

## Refresh və logout

`POST /tasks/token/refresh` yalnız `auth:web`, CSRF və `throttle:30,1` ilə açıqdır. `RefreshWebTokenAction` user-əsaslı cache lock götürür, sessiyadakı refresh tokenlə Password Grant refresh edir, yeni tokenləri sessiyada saxlayır və yalnız `access_token`, `expires_at` JSON qaytarır. Refresh token və client secret cavabda yoxdur.

`LogoutAction` → `RevokeWebTokenAction` cari session-ın `oauth_access_tokens` və bağlı `oauth_refresh_tokens` sətrini revoked edir, session token sahələrini unudur, web guard-u logout edir, session-ı invalidasiya və CSRF token-i regenerate edir. Başqa cihaz tokenləri toxunulmur.

`WebTokenLifecycleTest` login, real Bearer API sorğusu, refresh response-un secret/refresh token daşımaması, logout revocation-u və köhnə tokenin 401 qaytarmasını test edir.
