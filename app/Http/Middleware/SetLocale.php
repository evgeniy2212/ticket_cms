<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Session;

    class SetLocale
    {
        /**
         * Смена языка
         *
         * @param \Illuminate\Http\Request $request
         * @param \Closure                 $next
         *
         * @return mixed
         */
        public function handle($request, Closure $next)
        {
            $raw_locale = Session::get('backend_locale');

            if (in_array($raw_locale, config('app.backend_locales'))) {
                $locale = $raw_locale;
            } else {
                $locale = config('app.backend_locale');
            }

            app()->setLocale($locale);

            return $next($request);
        }
    }
