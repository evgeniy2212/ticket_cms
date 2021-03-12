# Artjoker Boilerplate for Laravel 7

**PHP:** 7.4  
**Database:** PostgreSQL 12.5 or MySQL 8

### Demo Credentials

**Admin:** admin@example.com  
**Password:** secret

**User:** user@example.com  
**Password:** secret

### Locally Installation

- `git clone https://git.artjoker.ua/laravel/boilerplate.git boilerplate`
- `cd boilerplate`
- `cp .env.example .env`
- Run `docker-compose up -d`
- Inside php container `docker-compose exec php bash`
- `composer install`
- `php artisan key:generate`
- `php artisan migrate:fresh --seed`
- Inside node container `docker-compose run node bash`
- `yarn`
- `yarn dev`
- Run `docker-compose down && docker-compose up -d`
- Open in browser `http://localhost/`

If you've done it once, you've done it a million times. :)

### Archive of Color Admin Theme

[color_admin_v4.6.7z](https://git.artjoker.ua/laravel/boilerplate/-/blob/master/theme/color_admin_v4.6.7z)

### Documentation

[Click here for the documentation](https://git.artjoker.ua/laravel/boilerplate/-/wikis/Artjoker-Boilerplate-Documentation)




