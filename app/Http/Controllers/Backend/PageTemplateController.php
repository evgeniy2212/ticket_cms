<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Template\CreateRequest;
use App\Models\FieldType;
use App\Models\PageTemplate;
use App\Providers\Backend\TemplateProvider;
use Illuminate\Http\Request;

class PageTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $templates = PageTemplate::active()->paginate(config('app.limits.backend.pagination'));

        return view('backend.templates.index', [
            'templates' => $templates,
            'permission' => 'pages',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('backend.templates.create', [
            'field_types' => FieldType::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateRequest  $request
     * @param  TemplateProvider  $provider
     */
    public function store(CreateRequest $request, TemplateProvider $provider)
    {
        $provider
            ->storeTemplate($request->items, $request->fields);

        return response()->json(['templates' => $provider->getTemplate()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return PageTemplate::find($id)->load([
            'fields.type',
            'fields.fieldItems' => function ($q) {
                return $q->orderBy('id', 'ASC');
            },
        ])
            ->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        dd(PageTemplate::find($id)->fields);
        return view('backend.templates.edit', [
            'itemId' => $id,
            'field_types' => FieldType::all(),
            'template' => PageTemplate::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request, $id)
    {
        PageTemplate::destroy($id);

        if ($request->wantsJson()) {
            return response()->json(['redirectUrl' => route('backend.templates.index')]);
        } else {
            return redirect()->route('backend.templates.index');
        }
    }
}
