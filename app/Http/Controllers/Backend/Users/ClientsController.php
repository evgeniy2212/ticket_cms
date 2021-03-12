<?php

    namespace App\Http\Controllers\Backend\Users;

    use App\Models\Client;
    use Carbon\Carbon;
    use Exception;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Arr;
    use function bcrypt;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Str;
    use function redirect;
    use Illuminate\View\View;
    use App\Http\Requests\Backend\Clients\StoreRequest;

    class ClientsController extends Controller
    {

        public function __construct()
        {
            $this->middleware('permission:list clients', ['only' => ['index']]);
            $this->middleware('permission:add clients', ['only' => ['create', 'store']]);
            $this->middleware('permission:edit clients', ['only' => ['edit', 'update']]);
            $this->middleware('permission:delete clients', ['only' => ['destroy', 'restore']]);
        }

        /**
         * Display a listing of the resource.
         *
         * @param Request $request
         *
         * @return View
         */
        public function index(Request $request)
        {
            $clients = Client::select('id', 'first_name', 'email', 'phone', 'active');

            if (auth()->user()->can('delete clients')) {
                $clients->withTrashed()->orderBy('deleted_at');
            }

            if ($request->has('search') && $request->search != '') {
                $clients = $clients->where('name', 'like', "%" . $request->search . "%")
                    ->orWhere('email', 'like', "%" . $request->search . "%")
                    ->orWhere('phone', 'like', "%" . $request->search . "%");
            }

            return view('backend.clients.index', [
                'clients'    => $clients->paginate($request->get('limit') ?? config('app.limits.backend.pagination')),
                'permission' => 'clients',
            ]);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return View
         */
        public function create()
        {
            return view('backend.clients.create', [
                'partners' => [],
            ]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param StoreRequest $request
         *
         * @return RedirectResponse
         */
        public function store(StoreRequest $request)
        {

            $data                    = $request->all();
            $data['active']          = isset($request->active);
            $password                = $request->password != '' ? $request->password : Str::random(6);
            $data['password']        = bcrypt($password);
            $client                  = Client::create($data);

            return redirect(
                $request->get('action') == 'continue'
                    ? route('backend.clients.edit', ['client' => $client])
                    : route('backend.clients.index')
            )->with('success', ['text' => __('backend.client_created')]);
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
            $client = Client::findOrFail($id);
            if (auth()->user()->can('delete clients')) {
                $client->withTrashed();
            }
            return view('backend.clients.edit', [
                'client'   => $client,
                'partners' => [],
            ]);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param StoreRequest $request
         * @param int          $client
         *
         * @return RedirectResponse
         */
        public function update(StoreRequest $request, $client)
        {
            $client         = Client::findOrFail($client);

            $data                    = $request->all();
            $data['active']          = isset($request->active);
            if ($data['password'] && ($data['password'] != '' || $data['password'] != null)) {
                $data['password'] = bcrypt($data['password']);
            } else {
                Arr::forget($data, 'password');
            }
            $client->fill($data);
            $client->save();

            return redirect(
                $request->get('action') == 'continue'
                    ? route('backend.clients.edit', ['client' => $client])
                    : route('backend.clients.index')
            )->with('success', ['text' => __('backend.client_updated')]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param int $id
         *
         * @return RedirectResponse
         * @throws Exception
         */
        public function destroy($id)
        {
            $client = Client::withTrashed()->findOrFail($id);
            if ($client->trashed()) {
                $client->forceDelete();
            } else {
                $client->active = false;
                $client->save();
                $client->delete();
            }
            return redirect(route('backend.clients.index'))->with('success', ['text' => __('backend.deleted')]);
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
            Client::withTrashed()->find($id)->restore();

            return redirect()->route('backend.clients.index')->with('success', ['text' => __('backend.success_title')]);
        }

        /**
         * Search users(ajax)
         *
         * @param Request $request
         *
         * @return mixed
         */
        public function search(Request $request)
        {
            return Client::onlyActive()
                ->where('email', 'LIKE', '%' . $request->get('q', '') . '%')
                ->orWhere('name', 'LIKE', '%' . $request->get('q', '') . '%')
                ->take(10)->get(['id', 'name', 'email']);
        }

    }
