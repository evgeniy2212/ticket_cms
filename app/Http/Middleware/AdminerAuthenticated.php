<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;

    class AdminerAuthenticated
    {
        /**
         * Handle an incoming request.
         *
         * @param Request     $request
         * @param Closure     $next
         * @param string|null $guard
         *
         * @return mixed
         */
        public function handle($request, Closure $next, $guard = null)
        {
            if (auth()->guard('admin')->check()) {
                if (auth()->guard('admin')->user()->hasRole('Superadmin')) {
                    return $next($request);
                } else {
                    return redirect(route('backend.home'));
                }
            }
            return redirect(url('/'));
        }
    }
