<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Backend\Page\PageRequest;
    use App\Models\FieldType;
    use App\Models\Page;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\View\View;

    class PagesController extends Controller
    {

        public function __construct()
        {
            $this->middleware('permission:list pages', ['only' => ['index']]);
            $this->middleware('permission:add pages', ['only' => ['create', 'store']]);
            $this->middleware('permission:edit pages', ['only' => ['edit', 'update']]);
            $this->middleware('permission:delete pages', ['only' => ['destroy', 'restore']]);
        }

        /**
         * Show all templates of emails
         *
         * @return View
         */
        public function index()
        {
            $pages = Page::active()->paginate(config('app.limits.backend.pagination'));

            return view('backend.pages.index', [
                'pages'      => $pages,
                'permission' => 'pages',
            ]);
        }

        /**
         * Editing of select template email
         *
         * @param $page
         *
         * @return View
         */
        public function edit($page)
        {
            $page = Page::find($page);

            return view('backend.pages.edit', [
                'page' => $page,
            ]);
        }

        /**
         * Update of select template email
         *
         * @param PageRequest $request
         * @param int         $page
         *
         * @return RedirectResponse
         */
        public function update(PageRequest $request, $page)
        {
            $page         = Page::find($page);
            $page->alias  = $request->alias;
            $page->title  = $request->title;
            $page->text   = $request->text;
            $page->active = $request->active ? $request->active : 0;
            $page->save();

            return redirect(
                $request->get('action') == 'continue'
                    ? route('backend.pages.edit', ['page' => $page])
                    : route('backend.pages.index')
            )->with('success', ['text' => __('backend.page_updated')]);
        }

        /**
         * Added the template email
         *
         * @return View
         */
        public function create()
        {
            return view('backend.pages.create', [
                'field_types' => FieldType::all(),
            ]);
        }

        /**
         * Create the template email
         *
         *
         * @param PageRequest $request
         *
         * @return RedirectResponse
         */
        public function store(PageRequest $request)
        {
            $page         = new Page();
            $page->alias  = $request->alias;
            $page->title  = $request->title;
            $page->text   = $request->text;
            $page->active = $request->active ? $request->active : 0;
            $page->type   = Page::TYPE_BASIC;
            $page->save();

            return redirect(
                $request->get('action') == 'continue'
                    ? route('backend.pages.edit', ['page' => $page])
                    : route('backend.pages.index')
            )->with('success', ['text' => __('backend.page_created')]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param int $page
         *
         * @return RedirectResponse
         */
        public function destroy($page)
        {
            Page::destroy($page);
            return redirect()->route('backend.pages.index')
                ->with('success', ['text' => __('backend.page_deleted')]);
        }

    }
