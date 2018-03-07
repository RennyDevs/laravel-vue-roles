<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permisologia\Permission;
use App\Http\Requests\PermissionUpdateRequest;

class PermissionController extends Controller
{
    protected $module = 'permission';

    public function __construct()
    {
        $this->middleware('onlyAjax')->except(['index']);
        $this->middleware('permission:permission,index')->only(['index']);
        $this->middleware('permission:permission,show')->only(['show']);
        $this->middleware('permission:permission,update')->only(['update']);
        $this->middleware('permission:permission,destroy')->only(['destroy']);
        $this->middleware('permission:permission,restore')->only(['restore']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!request()->ajax()) return view('permisologia.permissions');

        $permissions = Permission::latest('id')
        ->search($request->search)
        ->withTrashed()
        ->paginate($request->num?:10);
        return response()->json($this->dataWhitPaginate($permissions, 'permissions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::withTrashed()->findOrFail($id);
        return response()->json($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PermissionUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, $id)
    {
        $permission = Permission::withTrashed()
                                ->findOrFail($id)
                                ->update($request->validated());
        return response()->json($permission);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rol = Permission::findOrFail($id)->delete();
        return response()->json($rol);
    }

    /**
     * restaura el recurso especificado desde el almacenamiento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $permission = Permission::withTrashed()->where('id', '=', $id)->first()->restore();
        return response()->json($permission);
    }
}
