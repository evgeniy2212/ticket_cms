<?php

    namespace App\Http\Controllers\Backend\Users;

    use App\Models\Permission;
    use App\Models\Role;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\RedirectResponse;
    use App\Http\Requests\Backend\Users\CreateRole;
    use Illuminate\View\View;

    class RolesController extends Controller
    {


        public function __construct()
        {
            $this->middleware('permission:list roles', ['only' => ['index']]);
            $this->middleware('permission:add roles', ['only' => ['create', 'store']]);
            $this->middleware('permission:edit roles', ['only' => ['edit', 'update']]);
            $this->middleware('permission:delete roles', ['only' => ['destroy']]);
        }

        /**
         * Display a listing of the resource.
         *
         * @return View
         */
        public function index()
        {
            $roles = Role::withCount('users')->paginate(config('app.limits.backend.pagination'));

            return view('backend.roles.index', [
                'roles'      => $roles,
                'permission' => 'roles',
            ]);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return View
         */
        public function create()
        {
            $permissions = Permission::get();
            return view('backend.roles.create', [
                'permissions' => $permissions,
            ]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param CreateRole $request
         *
         * @return RedirectResponse
         */
        public function store(CreateRole $request)
        {
            $role = Role::create(['name' => $request->name, 'active' => isset($request->active)]);
            $role->syncPermissions($request->roles);
            $role->save();
            return redirect(
                $request->get('action') == 'continue'
                    ? route('backend.roles.edit', ['role' => $role])
                    : route('backend.roles.index')
            )->with('success', ['text' => __('backend.role_created')]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param int $id
         *
         * @return View
         */
        public function edit($id)
        {
            $role        = Role::findOrFail($id);
            $role        = $role->findByName($role->name);
            $permissions = Permission::all();

            return view('backend.roles.edit', [
                'role'        => $role,
                'permissions' => $permissions,
            ]);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param CreateRole $request
         * @param int        $id
         *
         * @return RedirectResponse
         */
        public function update(CreateRole $request, $id)
        {
            $role         = Role::findOrFail($id);
            $role->name   = $request->name;
            $role->active = $request->active;
            $role->save();
            $role->syncPermissions($request->roles);
            return redirect(
                $request->get('action') == 'continue'
                    ? route('backend.roles.edit', ['role' => $role])
                    : route('backend.roles.index')
            )->with('success', ['text' => __('backend.role_updated')]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param int $id
         *
         * @return RedirectResponse
         */
        public function destroy($id)
        {
            Role::destroy($id);
            return redirect()->route('backend.roles.index')
                ->with('success', ['text' => __('backend.role_deleted')]);
        }
    }
