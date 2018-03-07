<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ { UserCreateRequest, UserUpdateRequest, ChangePasswordRequest};
use App\User;
use App\Models\Module;
use App\Models\Permisologia\Role;
use Auth;

class UserController extends Controller
{

    protected $module = 'user';

    public function __construct()
    {
        $this->middleware('onlyAjax')->except(['index','initWithOneUser']);
        $this->middleware('permission:user,index')->only(['index']);
        $this->middleware('permission:user,show')->only(['show']);
        $this->middleware('permission:user,store')->only(['store']);
        $this->middleware('permission:user,update')->only(['update']);
        $this->middleware('permission:user,destroy')->only(['destroy']);
        $this->middleware('permission:user,restore')->only(['restore']);
        $this->middleware('permission:user,initWithOneUser')->only(['initWithOneUser']);
        $this->middleware('permission:module,changeModule')->only(['changeModule']);
    }

    /**
     * Muestra una lista de recursos o la vista.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!request()->ajax()) return view('users.index');

        $users = User::latest('id')
        ->search($request->search)
        ->paginate($request->num?:10);
        $users->each(function ($user) {
            $user->module;
            $user->roles;
        });
        return response()->json($this->dataWhitPaginate($users, 'users'));
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     *
     * @param  \App\Http\Requests\UserCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $user->roles()->attach($data['roles']);
        $user->assignPermissionsOneUser($data['roles']);
        return response()->json($user);
    }

    /**
     * Mostrar el recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $user->module;
        $user->roles;
        return response()->json($user);
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     *
     * @param  \App\Http\Requests\UserUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        if($request->id == 1) return response(['errors' => 'Error al modificar usuario'], 422);

        $data = $request->validated();

        if( !empty($request->password) ){
            $data['password'] = bcrypt($this->validate($request, [
                'password' => 'string|min:6|confirmed'
            ])['password']);
        }
        // $user = User::findOrFail($id)->update($request->all());
        $user = User::findOrFail($id)->fill($data);
        $user->update_pivot($data['roles'], 'roles', 'role_id');
        $user->assignPermissionsOneUser($data['roles']);
        return response()->json($user->save());
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id === 1) return response(['error' => 'Error al modificar usuario'], 422);
        $user = User::findOrFail($id)->delete();
        return response()->json($user);
    }

    /**
     * restaura el recurso especificado desde el almacenamiento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if ($id == 1) return response(['error' => 'Error al modificar usuario'], 422);
        // Indicamos que la busqueda se haga en los registros eliminados con withTrashed
        // y restauramos el recurso
        User::withTrashed()->where('id', '=', $id)->restore();
        $user = User::findOrFail($id)->name;
        return response()->json($user);
    }

    /**
     * se inicia la session con un recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function initWithOneUser($id)
    {
        if ($id == 1) return response('Error de usuario', 422);
        Auth::loginUsingId($id);
        return redirect()->to('/');
    }

    /**
     * Retorna los datos que se usaran para crear y editar.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister()
    {
        $modules = Module::all()->pluck('module', 'id');
        $roles = Role::all()->pluck('name', 'id');
        return response()->json(compact(['modules', 'roles']));
    }

    /**
     * Edita el password del usuario logueado.
     *
     * @param  \App\Http\Requests\UserUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function editPassword(ChangePasswordRequest $request){
        $data = $request->validated();
        $user = User::findOrFail(Auth::user()->id)->fill([
            'password' => bcrypt($data['passwordnew'])
        ]);
        return response()->json($user->save());
    }

    /**
     * Retorna los datos de los modulos.
     * Permite al usuario cambiarse de modulo.
     *
     * @param  \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    public function changeModule(Request $request)
    {
        if ($request->method() == 'POST') {
            $user = User::findOrFail(Auth::user()->id)->fill([
                'module_id' => $request->key
            ])->save();
            return response()->json($user);
        } elseif ($request->method() == 'GET') {
            $module  = Auth::user()->module()->pluck('module', 'id')->toArray();
            $modules = (Auth::user()->iCan('changeModule', 'module')) ? 
            array_diff(Module::all()->pluck('module', 'id')->toArray(), $module) : null;

            return response()->json(compact('modules', 'module'));
        }
    }
}
