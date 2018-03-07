<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permisologia\ { Role, Permission };
use App\Http\Requests\ { RolStoreRequest, RolUpdateRequest };

class RoleController extends Controller
{
    protected $module = 'rol';

    public function __construct()
    {
        $this->middleware('onlyAjax')->except(['index']);
        $this->middleware('permission:rol,index')->only(['index']);
        $this->middleware('permission:rol,store')->only(['store']);
        $this->middleware('permission:rol,show')->only(['show']);
        $this->middleware('permission:rol,update')->only(['update']);
        $this->middleware('permission:rol,destroy')->only(['destroy']);
        $this->middleware('permission:rol,restore')->only(['restore']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!request()->ajax()) return view('permisologia.roles');

        $roles = Role::latest('id')
        ->search($request->search)
        ->paginate($request->num?:10);
        return response()->json($this->dataWhitPaginate($roles, 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RolStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolStoreRequest $request)
    {
        $rol = Role::create($request->validated());
        if (!$request->special) $rol->permissions()->attach($request->special);
        $rol->update_pivot($request->permissions, 'permissions', 'permission_id');
        $rol->assignPermissionsAllUser();
        return response()->json($rol);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rol = Role::findOrFail($id);
        $rol->permissions = $rol->arrayOf('Permissions');
        return response()->json($rol);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RolUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolUpdateRequest $request, $id)
    {
        if($request->id == 1) return response(['errors' => 'Error al modificar Rol'], 422);
        $data = $request->validated();
        $rol = Role::findOrFail($id)->fill($data);
        ($data['special']) ?
        $rol->permissions()->detach($data['permissions']) :
        $rol->update_pivot($data['permissions'], 'permissions', 'id');
        $rol->assignPermissionsAllUser();
        return response()->json($rol->save());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id == 1) return response(['errors' => 'Error al modificar usuario'], 422);
        $rol = Role::findOrFail($id)->delete();
        return response()->json($rol);
    }

    /**
     * Retorna los datos que se usaran para crear y editar.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister()
    {
        $permissions = Permission::select('name', 'id', 'module', 'action')->get();
        return response()->json(compact(['permissions']));
    }

    /**
     * restaura el recurso especificado desde el almacenamiento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $rol = Role::withTrashed()->where('id', '=', $id)->first()->restore();
        $rol = Role::findOrFail($id)->name;
        return response()->json($rol);
    }
}
