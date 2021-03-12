<?php

    namespace App\Http\Controllers\Frontend;

    use App\Http\Controllers\Controller;
    use Illuminate\Contracts\Support\Renderable;

    class ProfileController extends Controller
    {

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth');
        }


        /**
         * Show the application profile page.
         *
         * @return Renderable
         */
        public function profile()
        {
            return view('frontend.profile');
        }

    }
