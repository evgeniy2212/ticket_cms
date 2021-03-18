<?php

    namespace App\Http\Controllers\Backend;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Backend\Page\PageRequest;
    use App\Models\FieldType;
    use App\Models\Page;
    use App\Models\PageTemplate;
    use App\Providers\Backend\PageProvider;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\View\View;

    class PagesController extends Controller
    {
        /**
         * Show all pages
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
         * Editing of select page
         *
         * @param $page
         *
         * @return View
         */
        public function edit($id)
        {
//            dd(Page::find($id));
            return view('backend.pages.edit', [
                'itemId' => $id,
                'field_types' => FieldType::all(),
                'page' => Page::find($id),
            ]);
        }

        /**
         * Update of select template email
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(PageRequest $request, $id)
        {
            dd('soon');
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
                'templates' => PageTemplate::all(),
            ]);
        }

        /**
         * Create the template email
         *
         * @param PageRequest $request
         * @param PageProvider $provider
         *
         * @return RedirectResponse
         */
        public function store(PageRequest $request, PageProvider $provider)
        {
            $provider
                ->storePage($request->items, $request->fields);

            return response()->json(['pages' => $provider->getPage()]);
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            return Page::find($id)->load([
                'fields.type',
                'fields.fieldItems' => function ($q) {
                    return $q->orderBy('id', 'ASC');
                },
            ])
                ->toJson();
        }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function preview($id)
        {
            return Page::find($id)->load([
                'fields.type',
                'fields.fieldItems' => function ($q) {
                    return $q->orderBy('id', 'ASC');
                },
            ])
                ->toJson();
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param Request $request
         * @param $id
         *
         */
        public function destroy(Request $request, $id)
        {
            Page::destroy($id);

            if ($request->wantsJson()) {
                return response()->json(['redirectUrl' => route('backend.pages.index')]);
            } else {
                return redirect()->route('backend.pages.index');
            }
        }

    }
