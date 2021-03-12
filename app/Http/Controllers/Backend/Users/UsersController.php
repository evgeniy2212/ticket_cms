<?php

    namespace App\Http\Controllers\Backend\Users;

    use App\Http\Requests\Backend\Users\CreateRequest;
    use App\Http\Requests\Backend\Users\UpdateRequest;
    use App\Models\Role;
    use App\Models\User;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Response;
    use Illuminate\Support\Facades\Cache;
    use function bcrypt;
    use App\Http\Controllers\Controller;
    use function redirect;

    class UsersController extends Controller
    {

        public function __construct()
        {
            $this->middleware('permission:list admins', ['only' => ['index', 'show']]);
            $this->middleware('permission:add admins', ['only' => ['create', 'store']]);
            $this->middleware('permission:edit admins', ['only' => ['edit', 'update']]);
            $this->middleware('permission:delete admins', ['only' => ['destroy']]);
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\View\View
         */
        public function index()
        {
            $users = auth()->user()->can('list admins')
                ? User::withTrashed()->paginate(config('app.limits.backend.pagination'))
                : User::paginate(config('app.limits.backend.pagination'));

            return view('backend.users.index', [
                'users'      => $users,
                'permission' => 'admins',
            ]);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view('backend.users.create', [
                'roles' => Role::all()->pluck('name', 'id')->toArray(),
            ]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param CreateRequest $request
         *
         * @return RedirectResponse
         */
        public function store(CreateRequest $request)
        {
            $user           = new User($request->all());
            $user->active   = $request->active;
            $user->password = bcrypt($request->password);
            $user->save();
            //Checking if a role was selected
            if (isset($request->role)) {
                $role = Role::find($request->role);
                $user->assignRole($role); //Assigning role to user
            }
            Cache::tags('users')->flush();
            return redirect(
                $request->get('action') == 'continue'
                    ? route('backend.users.edit', ['user' => $user])
                    : route('backend.users.index')
            )->with('success', ['text' => __('backend.user_created')]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param int $id
         *
         * @return Application|Factory|Response|\Illuminate\View\View
         */
        public function edit($id)
        {
            $user = auth()->user()->can('delete admins')
                ? User::withTrashed()->findOrFail($id)
                : User::findOrFail($id);
            return view('backend.users.edit', [
                'user'  => $user,
                'roles' => Role::all()->pluck('name', 'id'),
            ]);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param UpdateRequest $request
         * @param int           $id
         *
         * @return RedirectResponse
         */
        public function update(UpdateRequest $request, $id)
        {
            $user = User::findOrFail($id);
            $user->fill($request->all());
            if ($user->hasRole(User::SUPERADMIN) && (!isset($request->active) && Role::find($request->role)->name == User::SUPERADMIN)) {
                // you can`t remove last superadmin
                if (User::role(User::SUPERADMIN)->whereActive(true)->count() == 1) {
                    return back()->with(['danger' => ['text' => __('backend.cant_remove_last_admin')]]);
                }
            }
            $user->active = $request->active;

            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->save();
            if (isset($request->role)) {
                $user->syncRoles([$request->role]); //Assigning role to user
            }
            Cache::tags('users')->flush();
            return redirect(
                $request->get('action') == 'continue'
                    ? route('backend.users.edit', ['user' => $user])
                    : route('backend.users.index')
            )->with('success', ['text' => __('backend.user_updated')]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param $id
         *
         * @return RedirectResponse
         */
        public function destroy($id)
        {
            $user = User::withTrashed()->findOrFail($id);
            if ($user->hasRole(User::SUPERADMIN) && is_null($user->deleted_at)) {
                // you can`t remove last superadmin
                if (User::role(User::SUPERADMIN)->whereActive(true)->count() == 1 && $user->active == 1) {
                    return back()->with(['danger' => ['text' => __('backend.cant_remove_last_admin')]]);
                }
            }
            if ($user->trashed()) {
                $user->forceDelete();
            } else {
                $user->active = false;
                $user->save();
                $user->delete();
            }
            Cache::tags('users')->flush();
            return redirect()->route('backend.users.index')->with('success', ['text' => __('backend.deleted')]);
        }

        /**
         * Restore deleted user
         *
         * @param $id
         *
         * @return RedirectResponse
         */
        public function restore($id)
        {
            $user         = User::withTrashed()->find($id);
            $user->active = true;
            $user->save();
            $user->restore();
            Cache::tags('users')->flush();
            return redirect()->route('backend.users.index')->with('success', ['text' => 'User successfully restored']);
        }
    }
