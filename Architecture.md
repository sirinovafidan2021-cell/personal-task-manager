Şəxsi Tapşırıq İdarəetmə Sistemi (Personal Task Manager)
Texniki Arxitektura və İcra Spesifikasiyası
Sənədin məqsədi: Bu sənəd Personal Task Manager layihəsinin funksional və texniki tələblərini müəyyən edir. Codex bu sənədi əsas tələb mənbəyi kimi istifadə etməli, əvvəlcə mövcud Apiato layihəsini yoxlamalı, sonra işi mərhələli şəkildə həyata keçirməlidir.

Vacib: Bu sənəddə göstərilən qovluq və sinif adları məntiqi istiqamət verir. Apiato 13.x-in quraşdırılmış real strukturu, namespace-ləri və generator qaydaları yoxlanılmadan fərziyyə əsasında fayl yaradılmamalıdır.

1. Layihənin ümumi təsviri
1.1. Layihə haqqında
Personal Task Manager istifadəçilərə şəxsi tapşırıqlarını yaratmağa, siyahı şəklində görməyə, redaktə etməyə, tamamlama vəziyyətini dəyişməyə və silməyə imkan verən veb tətbiqidir.

Layihə Apiato 13.x və Porto Architecture əsasında hazırlanacaq. WEB interfeysi Blade ilə qurulacaq. Tapşırıqların bütün CRUD əməliyyatları RESTful API vasitəsilə həyata keçiriləcək. Brauzer API ilə JavaScript Fetch API vasitəsilə əlaqə saxlayacaq.
1.2. Layihənin məqsədləri
- Apiato 13.x və Porto prinsiplərini praktik tətbiq etmək.
- WEB qeydiyyat, giriş və çıxış axınlarını hazırlamaq.
- WEB autentifikasiyasını Laravel Session və web guard ilə həyata keçirmək.
- API autentifikasiyasını müəllimin tələbinə uyğun Laravel Passport Password Grant ilə həyata keçirmək.
- WEB və API məsuliyyətlərini ayırmaq.
- Tapşırıqlar üçün RESTful CRUD API yaratmaq.
- Fetch API ilə səhifə yenilənmədən əməliyyatlar aparmaq.
- İstifadəçilərin məlumatlarını bir-birindən təcrid etmək.
- Təhlükəsiz, test edilə bilən və saxlanması asan kod yazmaq.
1.3. Əsas funksiyalar
1. İstifadəçi qeydiyyatı.
2. Login və logout.
3. İstifadəçinin şəxsi tapşırıqlarının siyahısı.
4. Yeni tapşırıq yaratmaq.
5. Tapşırığı redaktə etmək.
6. Tapşırığı silmək.
7. Tapşırığın tamamlanma vəziyyətini dəyişmək.
8. Bütün, tamamlanmış və tamamlanmamış tapşırıqları filtrləmək.
9. Passport access token və refresh token idarəetməsi.
10. İstifadəçi məlumatlarının və tapşırıqlarının qorunması.
1.4. Biznes qaydaları
- Hər tapşırıq yalnız bir istifadəçiyə məxsusdur.
- İstifadəçi yalnız öz tapşırıqlarını oxuya, yarada, yeniləyə və silə bilər.
- Tapşırığın sahibi autentifikasiya olunmuş istifadəçidən götürülür.
- user_id heç vaxt etibarlı mənbə kimi HTTP request-dən qəbul edilmir.
- İstifadəçi yalnız autentifikasiya olunduqdan sonra tapşırıq səhifələrinə daxil ola bilər.
- Bütün tapşırıq CRUD əməliyyatları API vasitəsilə həyata keçirilir.
- WEB səhifələri Blade ilə təqdim edilir.
- Tapşırıq əməliyyatları Fetch API ilə səhifə yenilənmədən həyata keçirilir.
- Parollar hash edilmiş formada saxlanılır.
- API autentifikasiyası Passport Password Grant istifadə edir.
- Başqa istifadəçiyə aid tapşırıq üçün 404 Not Found qaytarılır; beləliklə, resursun mövcudluğu açıqlanmır.
1.5. Layihənin əhatə dairəsi
Layihə tək tətbiqli şəxsi tapşırıq idarəetmə sistemidir.

Bu versiyaya daxil deyil:
- Komanda və rol idarəetməsi.
- Ortaq tapşırıqlar və tapşırıq təyin etmə.
- Şərhlər və fayl əlavələri.
- Bildirişlər.
- Administrator paneli.
- Kateqoriyalar, etiketlər, layihələr və sprintlər.
2. Texnologiyalar və texniki məhdudiyyətlər
2.1. Backend
- PHP 8.4.x (mövcud mühit və Composer tələbləri ilə uyğunluq yoxlanılmalıdır).
- Laravel 12.x.
- Apiato 13.x.
- Porto Architecture.
- Laravel Passport.
- Eloquent ORM.
- Composer.
2.2. Database
- MySQL.
- InnoDB.
- utf8mb4.
- Mövcud serverin dəstəklədiyi uyğun utf8mb4 collation.
Database strukturu migration-larla idarə edilməlidir. Database-in yaradılması, migration-lar, əlaqələr, indekslər və seed məlumatları Codex tərəfindən avtomatlaşdırılmalıdır — lakin yalnız mövcud DB istifadəçisinin icazələri daxilində.
2.3. Frontend
- HTML5.
- CSS3.
- Blade.
- Vanilla JavaScript.
- Fetch API.
- JSON.
Tapşırıq əməliyyatları üçün jQuery və Livewire istifadə edilməməlidir. Mövcud layihədə Vite və ya başqa frontend build sistemi varsa, səbəbsiz dəyişdirilməməlidir.
2.4. Test və API yoxlaması
- Pest (layihədə quraşdırılmış test versiyasına uyğun).
- Laravel HTTP tests.
- Database tests.
- Postman collection və environment.
2.5. Versiya və dəyişiklik məhdudiyyətləri
1. Laravel, Apiato və mövcud Composer paketlərinin versiyaları səbəbsiz dəyişdirilməməlidir.
2. composer update bütöv layihə üzrə avtomatik icra edilməməlidir.
3. Yeni paket yalnız həqiqətən zəruridirsə və mövcud paketlərlə uyğunluğu yoxlanıldıqdan sonra əlavə edilməlidir.
4. .env, database məlumatları, Passport secret-ləri və açarlar Git-ə əlavə edilməməlidir.
5. Mövcud Apiato komponentləri və autentifikasiya mexanizmləri yoxlanılmadan eyni işi görən yeni komponent yaradılmamalıdır.
6. Layihənin real qovluq strukturu və namespace qaydaları yoxlanılmadan nümunə struktur kor-koranə tətbiq edilməməlidir.
3. Apiato və Porto arxitekturası
3.1. Əsas prinsip
Layihənin əsas biznes funksionallığı TaskManagement Container daxilində yerləşdirilməlidir. İstifadəçi və autentifikasiya funksionallığı üçün Apiato layihəsində mövcud olan User və Authentication komponentləri əvvəlcə yoxlanılmalı, uyğun olduqda təkrar istifadə edilməlidir.

Codex əvvəlcə aşağıdakıları araşdırmalıdır:
- app/Containers daxilində mövcud Container-lər.
- app/Ship daxilində Parent siniflər və ümumi konfiqurasiya.
- Mövcud User modeli və onun namespace-i.
- config/auth.php guard və provider konfiqurasiyası.
- WEB və API route-larının yüklənmə mexanizmi.
- Apiato 13.x generatorlarının və route naming qaydalarının real istifadəsi.
- Passport-un quraşdırılıb-quraşdırılmaması və faktiki versiyası.
3.2. Komponentlərin məsuliyyətləri
Komponent	Məsuliyyət
Route	HTTP sorğusunu uyğun Controller-ə yönləndirir
Middleware	Autentifikasiya və giriş nəzarətini həyata keçirir
Request	Gələn məlumatları validasiya edir
Controller	Sorğunu qəbul edir, uyğun Action-ı çağırır və cavabı qaytarır
Action	İstifadə ssenarisini (use case) koordinasiya edir
Task	Təkrar istifadə edilə bilən əməliyyat və biznes məntiqini kapsullaşdırır
Model	Database məlumatlarını və Eloquent əlaqələrini təmsil edir
Transformer	API resurslarının çıxış formatını müəyyən edir
Migration	Database strukturunu yaradır və dəyişir
Seeder	Lokal nümunə məlumatları əlavə edir


Controller daxilində Eloquent sorğuları və biznes qaydaları yerləşdirilməməlidir. Action və Task-lar süni şəkildə çoxaldılmamalıdır: hər sinifin aydın məsuliyyəti olmalıdır. Sadə bir əməliyyat üçün lazımsız abstraksiya yaradılmamalıdır.
3.3. Container strukturu
Məntiqi hədəf Container:

app/Containers/AppSection/TaskManagement/

Apiato 13.x layihəsində faktiki Section adı və autoload qaydası əvvəlcə yoxlanılmalıdır. Əgər layihədə başqa standart istifadə olunursa, ona uyğunlaşmaq lazımdır.

Gözlənilən komponent qrupları:
TaskManagement/
├── Actions/
├── Tasks/
├── Models/
├── Data/
│   └── Transporters/
├── UI/
│   ├── API/
│   │   ├── Controllers/
│   │   ├── Requests/
│   │   ├── Transformers/
│   │   └── Routes/
│   └── WEB/
│       ├── Controllers/
│       ├── Requests/
│       ├── Routes/
│       └── Views/
├── Migrations/
└── Seeders/
Bu ağacın bütün qovluqlarını əvvəlcədən boş şəkildə yaratmaq tələb olunmur. Yalnız real ehtiyac olan komponentlər yaradılmalıdır. Apiato generatorları mövcuddursa, əvvəlcə onların istifadəsi araşdırılmalıdır.
3.4. Sorğunun ümumi axını
HTTP Request
    ↓
Route
    ↓
Middleware
    ↓
Request Validation
    ↓
Controller
    ↓
Action
    ↓
Task (lazım olduqda)
    ↓
Model / Database
    ↓
Transformer (API cavabı üçün)
    ↓
HTTP Response
WEB və API Controller-ləri ayrı olmalıdır. WEB Controller Blade səhifələrini qaytarır; API Controller JSON cavabını qaytarır.
3.5. Route yerləşdirilməsi
- WEB route-ları Container-in UI/WEB/Routes qovluğunda yerləşdirilməlidir.
- API route-ları Container-in UI/API/Routes qovluğunda yerləşdirilməlidir.
- Apiato 13.x-in route naming və route discovery qaydalarına əməl edilməlidir.
- Hər route faylında bir route olması tələbi quraşdırılmış Apiato versiyasının qaydalarına uyğun tətbiq edilməlidir.
- /v1 prefix-i dəqiq qorunmalıdır. Apiato və ya Laravel avtomatik /api prefix-i əlavə edirsə, yekun URL yoxlanılmalı və müəllimin tələb etdiyi /v1/... URL-lər təmin edilməlidir.
- Eyni route-lar həm standart Laravel route fayllarında, həm də Container daxilində təkrar qeydiyyata alınmamalıdır.
4. Database arxitekturası
4.1. Əsas cədvəllər
Biznes məlumatları üçün əsasən iki cədvəl istifadə olunur:
1. Mövcud users cədvəli.
2. Yeni tasks cədvəli.
Passport-un tələb etdiyi OAuth cədvəlləri ayrıca Passport migration-ları ilə idarə olunur. Mövcud users cədvəli və Passport cədvəlləri təkrar yaradılmamalıdır.
4.2. Users cədvəli
Apiato layihəsində mövcud User modeli və users cədvəli varsa, onlardan istifadə edilməlidir. Mövcud struktur yoxlanılmadan yeni users cədvəli və ya ikinci User modeli yaradılmamalıdır.

Tətbiqin tələb etdiyi istifadəçi sahələri:
Sütun	Tələb
id	Primary key
name	İstifadəçinin adı
email	Məcburi və unikal
password	Hash edilmiş parol
created_at	Yaradılma vaxtı
updated_at	Yenilənmə vaxtı


Əgər mövcud User modelində əlavə məcburi sütunlar varsa, qeydiyyat və seeder həmin struktura uyğunlaşdırılmalıdır.
4.3. Tasks cədvəli
Sütun	Tip / qayda
id	BIGINT, primary key
user_id	BIGINT, foreign key, məcburi
title	VARCHAR(150), məcburi
description	TEXT, nullable
is_completed	BOOLEAN, default false
created_at	Timestamp
updated_at	Timestamp


4.4. Əlaqələr və indekslər
- tasks.user_id → users.id foreign key.
- User modelində hasMany(Task::class).
- Task modelində belongsTo(User::class).
- tasks.user_id indekslənməlidir.
- tasks.user_id və tasks.is_completed üçün composite index yaradılmalıdır.
- User silindikdə ona aid tapşırıqların silinməsi ON DELETE CASCADE ilə təmin edilməlidir.
- title maksimum 150 simvol olmalıdır.
- description boş qala bilər.
- is_completed boolean olmalıdır.
Migration mövcud User cədvəlinin real primary key tipinə uyğun foreign key yaratmalıdır.
4.5. Passport cədvəlləri
Passport-un faktiki quraşdırılmış versiyası yoxlanılmalıdır. Həmin versiyanın migration publish və install qaydaları tətbiq edilməlidir. OAuth client, access token, refresh token və digər tələb olunan cədvəllər təkrar yaradılmamalıdır.
4.6. Database-in avtomatik hazırlanması
Codex aşağıdakı ardıcıllığa əməl etməlidir:
1. .env və Laravel database konfiqurasiyasını yoxlamaq.
2. Aktiv DB connection, host, port, database adı və istifadəçi icazələrini yoxlamaq.
3. Database mövcud olub-olmadığını yoxlamaq.
4. Database yoxdursa, konfiqurasiya edilmiş DB istifadəçisinin icazəsi daxilində yaratmağa çalışmaq.
5. İcazə yoxdursa, konkret səbəbi bildirmək və istifadəçidən tələb olunan minimal əməliyyatı istəmək.
6. Mövcud migration statusunu yoxlamaq.
7. Yalnız tələb olunan yeni migration-ları yaratmaq və icra etmək.
8. Foreign key və indeksləri yoxlamaq.
9. Passport migration və açar/client konfiqurasiyasını yoxlamaq.
10. İki lokal test istifadəçisi və hər biri üçün üç tapşırıq yaratmaq.
11. Nəticəni database sorğuları və testlərlə təsdiqləmək.
Məlumat itkisinə yol verilməməlidir. İstifadəçinin açıq razılığı olmadan migrate:fresh, db:wipe, cədvəl silmə, mövcud məlumatları truncate etmə və ya destruktiv migration icra edilməməlidir. Database yaratmaq üçün root parolu uydurulmamalı və mövcud .env dəyərləri özbaşına dəyişdirilməməlidir.
4.7. Seed məlumatları
Development mühiti üçün iki istifadəçi yaradılmalıdır:
Email	Tapşırıq sayı
user1@example.com	3
user2@example.com	3


- Hər istifadəçinin üç fərqli tapşırığı olmalıdır.
- Tapşırıqların user_id dəyərləri düzgün istifadəçiyə bağlanmalıdır.
- Seeder təkrar icra ediləndə təkrar məlumat yığmamalıdır; idempotent olmalıdır.
- Nümunə parollar yalnız lokal development üçün olmalıdır.
- README-də lokal test hesabları aydın göstərilməlidir.
- Bu hesablar production mühitində yaradılmamalıdır.
5. WEB və API arxitekturası
5.1. WEB səhifələri və route-lar
Method	URL	Təyinat	Giriş
GET	/register	Qeydiyyat səhifəsi	Guest
POST	/register	Qeydiyyat əməliyyatı	Guest
GET	/login	Login səhifəsi	Guest
POST	/login	Login əməliyyatı	Guest
POST	/logout	Logout	Authenticated
GET	/tasks	Tapşırıqlar səhifəsi	auth:web
GET	/tasks/create	Tapşırıq yaratma səhifəsi	auth:web
GET	/tasks/{id}/edit	Redaktə səhifəsi	auth:web


- WEB formaları adi POST və CSRF qorunması ilə işləməlidir.
- Giriş etməmiş istifadəçi qorunan səhifəyə daxil olduqda login səhifəsinə yönləndirilməlidir.
- Login olmuş istifadəçi login/register səhifələrinə daxil olduqda uyğun qorunan səhifəyə yönləndirilə bilər.
- WEB səhifələrinin göstərilməsi WEB Controller-lərin məsuliyyətidir.
- Tapşırıq CRUD əməliyyatları WEB Controller-də deyil, API vasitəsilə həyata keçirilməlidir.
5.2. API endpoint-ləri
Bütün endpoint-lər /v1 prefix-i altında olmalıdır.
Method	Endpoint	Təyinat
GET	/v1/tasks	İstifadəçinin tapşırıqlarını siyahılamaq
GET	/v1/tasks/{id}	Bir tapşırığı göstərmək
POST	/v1/tasks	Tapşırıq yaratmaq
PATCH	/v1/tasks/{id}	Tapşırığı yeniləmək
DELETE	/v1/tasks/{id}	Tapşırığı silmək


Bütün task API endpoint-ləri auth:api ilə qorunmalıdır. api guard Passport driver və mövcud User provider ilə uyğun konfiqurasiya edilməlidir.
5.3. Tapşırıq filtrləri
GET /v1/tasks aşağıdakı filter-ləri dəstəkləməlidir:
- filter=all — bütün tapşırıqlar.
- filter=completed — tamamlanmış tapşırıqlar.
- filter=pending — tamamlanmamış tapşırıqlar.
Filter verilmədikdə all tətbiq edilməlidir. Naməlum filter üçün 422 Unprocessable Content qaytarılmalıdır.

Pagination bonus funksiyadır; əsas CRUD və filter tələbləri işlək olduqdan sonra əlavə edilə bilər.
5.4. WEB və API əlaqəsi
1. İstifadəçi login formasını göndərir.
2. Server istifadəçinin məlumatlarını yoxlayır.
3. Laravel web guard ilə WEB autentifikasiyası aparılır.
4. Session ID yenilənir.
5. Server Passport Password Grant vasitəsilə access və refresh token əldə edir.
6. Tokenlər server tərəfində session daxilində saxlanılır.
7. Qorunan Blade səhifəsinə yalnız access token ötürülür.
8. JavaScript Authorization: Bearer ... başlığı ilə API sorğusu göndərir.
9. API Passport guard vasitəsilə tokeni yoxlayır.
10. API JSON cavabı qaytarır.
Client secret və refresh token heç vaxt brauzerə verilməməlidir.
6. Autentifikasiya və token axınları
6.1. Qeydiyyat
- Qeydiyyat WEB vasitəsilə həyata keçirilir.
- Sahələr: name, email, password, password_confirmation.
- Email unikal olmalıdır.
- Parol üçün minimum uzunluq və Laravel validation qaydaları tətbiq edilməlidir.
- Parol yalnız Laravel Hash vasitəsilə hash edilərək saxlanılmalıdır.
- Mövcud Apiato User modeli və qeydiyyat komponenti uyğun olduqda təkrar istifadə edilməlidir.
- Uğurlu qeydiyyatdan sonra istifadəçi login səhifəsinə yönləndirilməlidir.
- Qeydiyyat zamanı istifadəçi başqa istifadəçinin məlumatlarına çıxış əldə etməməlidir.
6.2. Login və Password Grant
Müəllimin tələbinə əsasən Passport Password Grant mütləq istifadə edilməlidir. Laravel sənədləri Password Grant-i yeni tətbiqlər üçün tövsiyə etmir; lakin bu layihədə tələb açıq şəkildə verildiyindən həmin grant tətbiq olunacaq.

Codex quraşdırılmış Passport versiyasını yoxlamalı və həmin versiyanın rəsmi qaydasına uyğun olaraq:
- Password Grant-in aktivləşdirilməsini;
- Password Grant client yaradılmasını;
- Passport-un tələb etdiyi User model müqavilə və trait-lərini;
- api guard konfiqurasiyasını;
- Passport açarları və migration-larını
qurmalıdır.

Login axını:
1. İstifadəçi email və parol göndərir.
2. Server WEB guard ilə etimadnamələri yoxlayır.
3. Uğurlu autentifikasiyadan sonra session ID regenerate edilir.
4. Server Passport /oauth/token endpoint-inə server-to-server grant_type=password sorğusu göndərir.
5. Sorğuda Passport client ID, client secret, email (username) və parol istifadə olunur.
6. Access token, refresh token və tokenin bitmə vaxtı server session-da saxlanılır.
7. İstifadəçi /tasks səhifəsinə yönləndirilir.
Passport token əldə etmək mümkün olmadıqda yarımçıq login vəziyyəti saxlanılmamalıdır: WEB autentifikasiyası və session təhlükəsiz şəkildə bağlanmalı, istifadəçiyə ümumi xəta göstərilməlidir. Həssas texniki detallar istifadəçiyə açıqlanmamalıdır.
6.3. Tokenlərin saxlanması
Məlumat	Saxlanma yeri
WEB session	Server-side session
Access token	Server-side session
Refresh token	Server-side session
Token bitmə vaxtı	Server-side session
Passport client ID	Environment/config
Passport client secret	Yalnız server environment/config


Access token brauzerə yalnız cari qorunan səhifənin işləməsi üçün təqdim edilə bilər. Token HTML-ə təhlükəsiz JSON encoding ilə ötürülməli, URL-ə, localStorage-a və sessionStorage-a yazılmamalıdır. Refresh token və client secret brauzerə heç vaxt ötürülməməlidir.
6.4. API autentifikasiyası
JavaScript API sorğularına aşağıdakı başlığı əlavə etməlidir:
Authorization: Bearer {access_token}
Accept: application/json
Etibarlı tokenlə sorğu davam edir. Token olmadıqda, etibarsız və ya ləğv edilmiş olduqda 401 qaytarılır. Autentifikasiya istifadəçinin resursa sahib olmasını avtomatik təsdiqləmir; ownership ayrıca yoxlanılmalıdır.
6.5. Refresh token prosesi
Refresh token yalnız server tərəfində istifadə olunur.
1. API sorğusu 401 qaytarır.
2. Frontend eyni-origin WEB refresh endpoint-inə CSRF qorunması ilə POST göndərir.
3. Server session-dan refresh tokeni götürür.
4. Server Passport /oauth/token endpoint-inə grant_type=refresh_token sorğusu göndərir.
5. Yeni access token və refresh token server session-da yenilənir.
6. Server frontend-ə yalnız yeni access token və lazım olan expiry məlumatını qaytarır.
7. Frontend əvvəlki API sorğusunu maksimum bir dəfə təkrar edir.
Refresh endpoint-i refresh tokeni və client secret-i response-a daxil etməməlidir. Refresh uğursuz olarsa, session və tokenlər təhlükəsiz şəkildə təmizlənməli, istifadəçi yenidən login etməlidir. Paralel refresh sorğuları üçün server-side lock və ya uyğun sinxronizasiya mexanizmi istifadə edilməlidir.
6.6. Logout
- Logout yalnız CSRF qorunmalı POST route ilə həyata keçirilməlidir.
- Server session-dakı token məlumatlarını əldə edir.
- Cari access token və onunla əlaqəli refresh token ləğv edilir.
- WEB guard logout edilir.
- Session invalidasiya edilir.
- CSRF token regenerate edilir.
- İstifadəçi login səhifəsinə yönləndirilir.
Logout təkrar çağırıldıqda təhlükəsiz və idempotent davranmalıdır. Logout-dan sonra əvvəlki access tokenlə API-yə müraciət 401 qaytarmalıdır. Bütün istifadəçinin başqa cihazlardakı tokenlərini ləğv etmək tələb olunmur; yalnız bu login sessiyasına aid tokenlər ləğv edilməlidir.
6.7. Middleware
- WEB qorunan səhifələri: auth:web.
- API task endpoint-ləri: auth:api.
- Login və register səhifələri: guest:web.
- Refresh endpoint-i: aktiv web session və CSRF qorunması tələb edir.
- API route-ları WEB session-a güvənməməli, Passport Bearer token tələb etməlidir.
7. API request və response müqaviləsi
7.1. Task sahələri
API aşağıdakı sahələri qaytara bilər:
- id
- user_id (yalnız cavabda göstərilməsi həqiqətən tələb olunursa; frontend bunu dəyişə bilməz)
- title
- description
- is_completed
- created_at
- updated_at
user_id create/update request-lərində qəbul edilmir. Mass assignment zamanı user_id request məlumatlarından modelə ötürülməməlidir.
7.2. Validasiya
Create
- title: required, string, maksimum 150 simvol.
- description: nullable, string.
- is_completed: optional, boolean; verilmədikdə false.
- user_id: qəbul edilmir və heç vaxt sahiblik təyin etmək üçün istifadə edilmir.
Update
- title: sometimes, required olduqda string, maksimum 150.
- description: sometimes, nullable, string.
- is_completed: sometimes, boolean.
- Boş PATCH request qəbul edilməməli və 422 qaytarmalıdır.
- user_id yeniləmə üçün qəbul edilmir.
7.3. HTTP status kodları
Status	İstifadə
200	Uğurlu GET/PATCH
201	Uğurlu create
204	Uğurlu delete, response body olmadan
401	Token yoxdur, etibarsızdır və ya ləğv edilib
404	Tapşırıq mövcud deyil və ya cari istifadəçiyə aid deyil
405	Dəstəklənməyən HTTP method
422	Validasiya və filter xətası
500	Gözlənilməyən server xətası


7.4. JSON cavabları
Uğurlu cavablar Apiato-nun mövcud response və Transformer standartlarına uyğun olmalıdır. Mövcud standart yoxdursa, vahid və sənədləşdirilmiş JSON formatı seçilməlidir.

Nümunə:
{
  "data": {
    "id": 1,
    "title": "Dərs oxumaq",
    "description": "Apiato arxitekturasını öyrənmək",
    "is_completed": false,
    "created_at": "2026-11-18T10:00:00Z",
    "updated_at": "2026-11-18T10:00:00Z"
  }
}
Validasiya xətası nümunəsi:
{
  "message": "The given data was invalid.",
  "errors": {
    "title": ["The title field is required."]
  }
}
Xəta formatı bütün endpoint-lərdə ardıcıl olmalıdır. Production cavablarında stack trace, SQL, parol, token və secret göstərilməməlidir.
7.5. Ownership qaydası
Bütün task sorğuları autentifikasiya olunmuş istifadəçinin əlaqəsi üzərindən icra edilməlidir. Məsələn, auth()->user()->tasks() və ya eyni təhlükəsiz məntiq. Global Task::find($id) ilə tapıb sonra ownership yoxlamasını unutmaq olmaz.

Başqa istifadəçiyə aid ID ilə GET, PATCH və DELETE sorğuları 404 qaytarmalıdır.
8. Frontend və Fetch API davranışı
8.1. Ümumi prinsip
WEB Controller Blade səhifəsini qaytarır. Tapşırıq məlumatları səhifə yükləndikdən sonra API-dən Fetch API ilə alınır. Tapşırıq əməliyyatları üçün jQuery və Livewire istifadə edilmir.
8.2. Səhifələr
- Register.
- Login.
- Tasks list.
- Create task.
- Edit task.
Create və edit səhifələri Blade səhifələridir; məlumatların saxlanması API vasitəsilə həyata keçirilir.
8.3. Fetch əməliyyatları
Frontend aşağıdakıları təmin etməlidir:
- Səhifə açıldıqda GET /v1/tasks.
- Edit səhifəsində GET /v1/tasks/{id} ilə formanın doldurulması.
- Create üçün POST /v1/tasks.
- Update üçün PATCH /v1/tasks/{id}.
- Delete üçün DELETE /v1/tasks/{id}.
- Tamamlama vəziyyətini dəyişmək üçün PATCH /v1/tasks/{id}.
- Filter dəyişdikdə uyğun query parametri ilə GET sorğusu.
8.4. İstifadəçi interfeysi vəziyyətləri
Frontend aşağıdakı halları aydın göstərməlidir:
- Loading: məlumat yüklənir.
- Empty: tapşırıq yoxdur.
- Success: əməliyyat uğurludur.
- Validation error: sahə üzrə xəta mesajları.
- Network/server error: ümumi xəta mesajı və yenidən cəhd imkanı.
- Unauthorized: token yeniləmə axınını başladır; alınmasa login səhifəsinə yönləndirir.
- Delete confirmation: silməzdən əvvəl istifadəçidən təsdiq alır.
Sorğu gedərkən eyni əməliyyatın təkrar göndərilməsinin qarşısı alınmalıdır. Uğurlu create/update/delete/toggle/filter əməliyyatları səhifəni yeniləmədən UI-da əks olunmalıdır.
8.5. JavaScript qaydaları
- API base URL bir yerdə müəyyən edilməlidir.
- Fetch sorğularında Accept: application/json göndərilməlidir.
- JSON body göndəriləndə Content-Type: application/json əlavə edilməlidir.
- Access token yalnız cari səhifə yaddaşında istifadə edilməlidir.
- Refresh token və client secret JavaScript-ə ötürülməməlidir.
- 401 sonrası refresh və retry maksimum bir dəfə olmalıdır; sonsuz retry loop olmamalıdır.
- Serverdən gələn istifadəçi məlumatları DOM-a təhlükəsiz şəkildə yerləşdirilməlidir; innerHTML ilə etibarsız mətn render edilməməlidir.
8.6. Dizayn
Sadə, istifadəsi rahat və responsive interfeys hazırlanmalıdır. Mobil və desktop ölçülərində əsas əməliyyatlar işləməlidir. Dizayn üçün mövcud layihənin frontend alətləri yoxlanılmalı, lazımsız ağır UI framework əlavə edilməməlidir.
9. Təhlükəsizlik tələbləri
- Parollar Laravel Hash vasitəsilə hash edilməlidir.
- Login zamanı session ID regenerate edilməlidir.
- WEB POST formaları CSRF qorunmalıdır.
- Refresh endpoint-i də CSRF qorunması altında olmalıdır.
- Cookie-lər production-da Secure, HttpOnly və uyğun SameSite parametrləri ilə konfiqurasiya edilməlidir.
- Client secret və refresh token yalnız server tərəfində qalmalıdır.
- Access token loglara yazılmamalıdır.
- Login və register endpoint-lərinə rate limiting tətbiq edilməlidir.
- Tapşırıq sahiblik yoxlaması hər API əməliyyatında tətbiq edilməlidir.
- user_id request-dən qəbul edilməməlidir.
- HTML-də istifadəçi məlumatları escape edilməlidir.
- SQL sorğuları parametrli Eloquent/Query Builder vasitəsilə icra edilməlidir.
- .env, Passport açarları və secret-lər Git-ə commit edilməməlidir.
- Production error response-larında daxili texniki məlumatlar göstərilməməlidir.
- CORS yalnız həqiqətən fərqli origin istifadə olunarsa konfiqurasiya edilməlidir; eyni-origin tətbiqdə lazımsız permissive CORS açılmamalıdır.
10. Test strategiyası və qəbul meyarları
10.1. WEB testləri
1. Guest /login və /register səhifələrini aça bilir.
2. Guest /tasks səhifəsinə daxil olduqda login-ə yönləndirilir.
3. Düzgün məlumatlarla qeydiyyat uğurludur.
4. Təkrarlanan email ilə qeydiyyat 422/validation xətası verir.
5. Düzgün login WEB session yaradır.
6. Yanlış login məlumatları qəbul edilmir.
7. Login sonrası session ID yenilənir.
8. Logout session-ı bağlayır.
10.2. API autentifikasiya testləri
1. Token olmadan task endpoint-ləri 401 qaytarır.
2. Etibarsız token 401 qaytarır.
3. Ləğv edilmiş token 401 qaytarır.
4. Etibarlı Passport tokeni ilə API işləyir.
5. API guard Passport driver istifadə edir.
10.3. CRUD və ownership testləri
1. İstifadəçi öz tapşırığını yarada bilir.
2. user_id request-dən ötürülərək başqa istifadəçinin adına tapşırıq yaratmaq mümkün deyil.
3. İstifadəçi yalnız öz tapşırıqlarını görür.
4. Başqa istifadəçinin tapşırığını GET etmək 404 qaytarır.
5. Başqa istifadəçinin tapşırığını PATCH etmək 404 qaytarır.
6. Başqa istifadəçinin tapşırığını DELETE etmək 404 qaytarır.
7. Düzgün PATCH yalnız göndərilən sahələri dəyişir.
8. DELETE uğurludur və tapşırıq silinir.
9. title boş olduqda və ya 150 simvoldan çox olduqda 422 qaytarılır.
10. is_completed boolean olmayan dəyəri qəbul etmir.
11. all, completed, pending filter-ləri düzgün işləyir.
12. Naməlum filter 422 qaytarır.
10.4. Token lifecycle testləri
1. Password Grant token əldə etmək mümkündür.
2. Refresh token yeni access token yaradır.
3. Refresh token brauzerə ötürülmür.
4. Refresh endpoint yalnız autentifikasiya olunmuş WEB session ilə işləyir.
5. Refresh uğursuz olduqda session təhlükəsiz bağlanır.
6. Logout cari tokenləri ləğv edir.
7. Logout-dan sonra əvvəlki access token işləmir.
8. Refresh zamanı paralel sorğular tokenləri korlamır.
10.5. Database testləri
- Migration təmiz test database-də uğurla işləyir.
- User–Task əlaqələri düzgündür.
- Foreign key və indekslər mövcuddur.
- is_completed default false-dur.
- Seeder iki istifadəçi və hər biri üçün üç tapşırıq yaradır.
- Seeder təkrar icra ediləndə duplicate məlumat yaratmır.
10.6. Qəbul meyarları
Layihə yalnız aşağıdakılar sübut edildikdə hazır sayılır:
- WEB guest/protected route davranışı doğrudur.
- API token olmadan 401 qaytarır.
- Yanlış məlumat 422 qaytarır.
- Başqa istifadəçinin tapşırığı 404 qaytarır.
- CRUD və filter-lər işləyir.
- Fetch əməliyyatları səhifəni yeniləmir.
- Refresh token axını işləyir.
- Logout-dan sonra köhnə token etibarsızdır.
- Migration, seeder və bütün testlər uğurla tamamlanır.
- README və Postman collection mövcuddur.
11. README və Postman təhvil materialları
11.1. README
README aşağıdakı bölmələri əhatə etməlidir:
1. Layihənin təsviri və istifadə məqsədi.
2. PHP, Composer, Laravel, Apiato, Passport və MySQL tələbləri.
3. Layihənin quraşdırılması.
4. .env konfiqurasiyası.
5. Database yaratmaq və migration/seeder icra etmək.
6. Passport açarları və Password Grant client hazırlamaq.
7. Development server-i işə salmaq.
8. Testləri icra etmək.
9. Lokal seed istifadəçiləri və parolları.
10. WEB route-ları və API endpoint-ləri.
11. Refresh token axınının izahı.
12. Arxitektura və request → Action → Task → Model → response axını.
11.2. Postman
Postman collection aşağıdakı sorğuları əhatə etməlidir:
- Register.
- Login / Password Grant token əldə etmək.
- GET tasks.
- GET task by ID.
- POST task.
- PATCH task.
- DELETE task.
- Filter all/completed/pending.
- Refresh token.
- Logout və köhnə tokenin etibarsızlığının yoxlanılması.
Postman environment dəyişənləri istifadə edilməlidir. Client secret və real parollar paylaşılacaq collection-a yazılmamalıdır. Nümunə dəyərlər və placeholder-lar istifadə edilməlidir.
12. Codex üçün icra qaydaları
12.1. Ümumi qayda
Codex bu sənədi layihənin əsas spesifikasiyası kimi qəbul etməlidir. Kod yazmağa başlamazdan əvvəl mövcud repository və Apiato quraşdırmasını araşdırmalıdır.
12.2. Mərhələli icra
Mərhələ 1 — Audit
- Layihənin qovluq strukturunu yoxla.
- PHP, Composer, Laravel, Apiato və Passport versiyalarını müəyyən et.
- Mövcud Container-ləri, User modelini, guard-ları, route-ları və migration-ları yoxla.
- Çatışmayan və ziddiyyətli məqamları hesabatla.
- Bu mərhələdə kodu dəyişmə.
Mərhələ 2 — Texniki plan
- Mövcud Apiato strukturuna uyğun fayl planı hazırla.
- WEB/API route-larını və autentifikasiya axınlarını planlaşdır.
- Passport Password Grant-in quraşdırılmış versiyada işləməsini təsdiqlə.
- Database və migration planını hazırla.
- Riskləri və tələb olunan environment dəyişənlərini göstər.
- Təsdiq tələb edən destruktiv və ya icazə çatışmazlığı yaradan addımları ayrıca qeyd et.
Mərhələ 3 — Database və backend
- Task modelini, migration-ı, əlaqələri, Request, Action, Task, Controller və Transformer komponentlərini hazırla.
- Mövcud User və Passport komponentlərini təkrar istifadə et.
- WEB və API route-larını yarat.
- Ownership və validation qaydalarını tətbiq et.
Mərhələ 4 — Authentication
- WEB register/login/logout axınını qur.
- Password Grant və refresh mexanizmini quraşdır.
- Tokenləri yalnız server session-da saxla.
- CSRF, session regeneration, rate limiting və token revocation tətbiq et.
Mərhələ 5 — Blade və JavaScript
- Register, login, tasks, create və edit səhifələrini hazırla.
- Fetch API CRUD, filter, loading, empty və error state-ləri qur.
- Token refresh və bir dəfə retry davranışını yoxla.
Mərhələ 6 — Test və sənədləşmə
- Pest testlərini yaz və icra et.
- Database migration və seeder-i yoxla.
- Postman collection hazırla.
- README-ni tamamla.
- Son nəticə və test hesabatını təqdim et.
12.3. Dəyişiklik və təhlükəsizlik qaydaları
- Audit tamamlanmadan kod dəyişmə.
- Mövcud işlək faylları səbəbsiz silmə və ya tam əvəz etmə.
- migrate:fresh, db:wipe, DROP TABLE, TRUNCATE və məlumat silən əmrləri açıq razılıq olmadan icra etmə.
- .env faylını oxuyarkən secret-ləri terminal çıxışında və hesabatda göstərmə.
- Composer paketlərini səbəbsiz yeniləmə.
- Apiato-nun Vendor Container-lərini dəyişmə.
- Test uğursuzdursa, onu gizlətmə və testləri keçmiş kimi təqdim etmə.
- Testləri yalnız nəticə həqiqətən uğurlu olduqda PASS kimi qeyd et.
- Bir mərhələdə problem yaranarsa, səbəbi və təsirini izah et; növbəti mərhələyə kor-koranə keçmə.
- İstifadəçinin razılığı olmadan production məlumatlarına və real hesablara toxunma.
12.4. Codex-in yekun hesabatı
İşin sonunda aşağıdakıları təqdim et:
- Yaradılmış və dəyişdirilmiş faylların siyahısı.
- İstifadə edilən real Apiato Container strukturu.
- WEB və API route siyahısı.
- Database və Passport konfiqurasiyasının xülasəsi (secret-lərsiz).
- İcra edilmiş migration və seeder nəticələri.
- Testlərin sayı və nəticəsi.
- Postman collection və README fayllarının yeri.
- Əl ilə görülməli qalan işlər və məhdudiyyətlər.
- Hələ həll olunmamış problemlər.
13. Rəsmi mənbələr və öyrənmə materialları
README-də hər mövzu üçün qısa izah, bu layihədən konkret nümunə və mənbə linki verilməlidir.
Mövzu	Öyrəniləcək məzmun	Mənbə
HTTP, REST və JSON	HTTP method-ları, status kodları, REST prinsipləri, JSON	https://developer.mozilla.org/en-US/docs/Web/HTTP
Laravel	Routing, validation, session, authentication, database	https://laravel.com/docs/12.x
Apiato / Porto	Container, Action, Task, Request, Controller, Transformer	https://apiato.io/docs/
Laravel Passport	OAuth2, Password Grant, access/refresh token	https://laravel.com/docs/12.x/passport
Fetch API	fetch, Request, Response, headers	https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API
JavaScript async	Promise, async/await, error handling	https://developer.mozilla.org/en-US/docs/Web/JavaScript
MySQL	Tables, foreign keys, indexes, transactions	https://dev.mysql.com/doc/
Same-Origin və CORS	Origin, same-origin policy, CORS	https://developer.mozilla.org/en-US/docs/Web/Security/Same-origin_policy


14. Son qəbul şərti
Layihə yalnız müəllimin funksional tələbləri, bu sənəddəki təhlükəsizlik qaydaları və test meyarları yerinə yetirildikdə tamamlanmış sayılır.

Əsas prioritetlər:
1. Apiato 13.x ilə uyğun düzgün arxitektura.
2. WEB session və Passport Password Grant-in işlək inteqrasiyası.
3. İstifadəçi məlumatlarının təcrid edilməsi.
4. API CRUD və Fetch API funksionallığı.
5. Database-in təhlükəsiz hazırlanması.
6. Testlərlə sübut edilən düzgünlük.
7. README və Postman ilə təqdim edilə bilən nəticə.