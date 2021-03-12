<?php

namespace App\Http\Controllers\Backend\Users;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Http\Requests\Backend\Users\CreatePermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PermissionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:list permissions', ['only' => ['index']]);
        $this->middleware('permission:add permissions', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit permissions', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete permissions', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $permissions = Permission::paginate(config('app.limits.backend.pagination'));
        return view('backend.permissions.index', [
            'permissions' => $permissions,
            'permission'  => 'permissions',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('backend.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePermission $request
     *
     * @return RedirectResponse
     */
    public function store(CreatePermission $request)
    {
        $permission = Permission::create(['name' => $request->name]);

        return redirect(
	        $request->get('action') == 'continue'
		        ? route('backend.permissions.edit', ['permission' => $permission])
		        : route('backend.permissions.index')
            )->with('success', ['text' => __('backend.permission_created')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return View
     */
    public function edit($id)
    {
        return view('backend.permissions.edit', [
            'permission' => Permission::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreatePermission $request
     * @param  int              $id
     *
     * @return RedirectResponse
     */
    public function update(CreatePermission $request, $id)
    {
        $permission       = Permission::findOrFail($id);
        $permission->name = $request->name;
        $permission->save();

        return redirect(
	        $request->get('action') == 'continue'
		        ? route('backend.permissions.edit', ['permission' => $permission])
		        : route('backend.permissions.index')
            )->with('success', ['text' => __('backend.permission_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        Permission::destroy($id);
        return redirect()->route('backend.permissions.index')
            ->with('success', ['text' => __('backend.permission_deleted')]);

    }
}
