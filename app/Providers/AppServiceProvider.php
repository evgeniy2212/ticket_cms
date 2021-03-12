<?php

    namespace App\Providers;

    use App\Services\Menu;
    use Illuminate\Routing\UrlGenerator;
    use Illuminate\Support\ServiceProvider;

    class AppServiceProvider extends ServiceProvider
    {
        /**
         * Register any application services.
         *
         * @return void
         */
        public function register()
        {
            $this->app->bind('Menu', function () {
                return new Menu();
            });
        }

        /**
         * Bootstrap any application services.
         *
         * @param UrlGenerator $url
         * @return void
         */
        public function boot(UrlGenerator $url)
        {
            if (env('APP_ENV') === 'production') {
                $url->forceScheme('https');
            }
        }
    }
