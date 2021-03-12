<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Routing\Redirector;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Session;

    class DashboardController extends Controller
    {

        public function index()
        {
            return view('backend.dashboard.index');
        }

        public function clearCache()
        {
            Cache::flush();
            return redirect()->back()->with('success', __('backend.cache_cleared'));
        }

        /**
         * Switch language
         *
         * @param $locale
         *
         * @return RedirectResponse|Redirector
         */
        public function setLocale($locale)
        {
            if (in_array($locale, config('app.backend_locales'))) {
                session()->put('backend_locale', $locale);
            }
            return redirect()->back();
        }

    }
