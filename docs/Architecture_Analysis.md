# Arxitektura auditi

## Nəticə

Layihə boş Laravel layihəsi deyil: Porto prinsipləri ilə qurulmuş Apiato tətbiqidir. Əsas biznes kodu `app/Containers/AppSection` altında, ümumi parent siniflər isə `app/Ship/Parents` altında yerləşir. Yeni tapşırıq funksionallığı həmin qaydaya uyğun olaraq `AppSection/TaskManagement` container-ində qurulacaq.

## Aşkarlanan versiyalar və struktur

- PHP: 8.4.27
- Laravel: 12.73.0
- Apiato Core: 13.2.1
- Laravel Passport: 13.12.0
- Test çərçivəsi: PHPUnit 11 (Pest quraşdırılmayıb; mövcud layihə PHPUnit konvensiyasından istifadə edir).

Mövcud `User` modeli `app/Containers/AppSection/User/Models/User.php` faylındadır. O, `HasApiTokens` trait-i ilə Passport-a hazırdır və `auth.php`-dakı `web` session guard-u, həmçinin `api` Passport guard-u eyni `users` provider-dən istifadə edir. `PassportServiceProvider` artıq Password Grant-i aktivləşdirir.

Apiato route discovery işləkdir: `UI/API/Routes/*.v1.private.php` faylları `/v1` prefiksi ilə, `UI/WEB/Routes` faylları isə web route kimi qeydiyyata alınır. `Apiato\\Support\\Facades\\Response` və parent `Transformer`, `Request`, `Action`, `Task` sinifləri mövcud standartdır.

## Mövcud verilənlər bazası

Aktiv mühit SQLite istifadə edir (`database/database.sqlite`); əlaqə və mövcud migration-lar uğurla yoxlanıldı. `users`, session, cache, job, Passport OAuth və authorization cədvəlləri artıq yaradılıb. `users` cədvəlində hələ məlumat yoxdur, `oauth_clients` cədvəlində də Password Grant client yoxdur. Passport açar faylları tapılmadı.

Spesifikasiya MySQL/InnoDB/utf8mb4 hədəfini göstərir. Mövcud `.env` konfiqurasiyasını və ya server DB-sini icazəsiz dəyişməmək üçün inkişaf yoxlaması mövcud SQLite ilə aparılacaq; yeni migration Laravel Schema API vasitəsilə MySQL ilə də uyğun olacaq. MySQL-ə keçid üçün yalnız `.env`-də mövcud, səlahiyyətli connection məlumatları verildikdən sonra migration icra edilməlidir.

## Boşluqlar

- `TaskManagement` container-i, `tasks` migration-ı, model, əlaqələr, CRUD endpoint-ləri və task siyasəti yoxdur.
- WEB register, task səhifələri, tokeni sessiyada saxlayan login, refresh endpoint-i və token revocation ilə logout yoxdur.
- Mövcud API token endpoint-ləri refresh tokeni response body-də qaytarır; bu yeni WEB axını üçün istifadə edilməyəcək.
- Login/register üçün ayrıca rate limiter yoxdur.
- Test konfiqurasiyası real `database/database.sqlite` faylını miras ala bilir. Bu təhlükəsizlik riski aradan qaldırılaraq testlər yalnız `:memory:` SQLite-də işlədiləcək.
- Layihə README-si standart Apiato mətnidir; Postman collection və layihə sənədləri yoxdur.

## Risklər və qərarlar

Password Grant client secret-i və Passport private key məxfi materialdır. Onlar kodda, testdə, README-də və Postman collection-da saxlanmayacaq. Lokal client/keys yalnız ayrıca təhlükəsiz provisioning əmri ilə yaradılacaq və nəticə `.env`-də saxlanacaq. Mövcud DB-də məlumat silən heç bir əmrdən istifadə edilməyəcək.

