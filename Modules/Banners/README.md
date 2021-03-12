### Laravel Banners Module
ver. 1.0.0

### Usage

1. Установить пакет (один раз) для поддержки модулей:
```
composer require nwidart/laravel-modules
```
2. Выполнить:
```
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```
3. В файл `composer.json` добавить `"Modules\\": "Modules/"`:
```
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Modules\\": "Modules/"
    },
```
4. В папке проекта создать папку `Modules/`
5. Создать пустой модуль:
```
php artisan module:make Blog --plain
```
6. Скопировать файлы модуля из репозитория:
```
git clone git@git.artjoker.ua:laravel/modules/laravel-banners.git Modules/Banners
```
7. Выполнить
```
composer dump-autoload
```
8. Выполнить
```
php artisan migrate
```
9. Проверить правильность префикса админпанели в файле роутов модуля `Modules/Banners/Routes/web.php`:
```
Route::group([
        'prefix' => config('app.admin_panel_uri'),
        'as'     => 'backend.',
    ], function () {
    ...
```
10. Добавить ссылку в меню админпанели на страницы модуля:
```

```
