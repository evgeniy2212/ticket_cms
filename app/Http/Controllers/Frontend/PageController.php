<?php

    namespace App\Http\Controllers\Frontend;

    use App\Http\Controllers\Controller;
    use App\Models\Page;
    use Illuminate\Contracts\Support\Renderable;

    class PageController extends Controller
    {
        /**
         * Show the application home page.
         *
         * @return Renderable
         */
        public function index()
        {
            return view('frontend.home');
        }

        /**
         * Show the any page.
         *
         * @param string $alias
         *
         * @return Renderable
         */
        public function page($alias)
        {
            $page = Page::where('alias', $alias)->whereActive(true)->first();
            if (!$page) {
                abort(404);
            }
            return view('frontend.page', ['page' => $page]);
        }


    }
