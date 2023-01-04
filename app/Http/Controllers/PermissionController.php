<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->filterData($request);
        $headers = $this->tableHeaders($request);

        return view('permission.index', compact('data', 'headers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('requestReferrer', URL::previous());
        
        $roles = Role::orderby('name', 'asc')->get();
        return view('permission.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        DB::transaction(function() use ($request){
            $permission = Permission::create($request->validated());

            if($request->role_id){
                $roles = Role::whereIn('id', $request->role_id)->get();
                $permission->syncRoles($roles);
            }
        });
        return redirect(Session::get('requestReferrer'))->with('success', 'Permission has been saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        Session::put('requestReferrer', URL::previous());
        
        $roles = Role::orderby('name', 'asc')->get();
        return view('permission.edit', compact('permission', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        
        DB::transaction(function() use($request, $permission){
            $permission->update($request->validated());

            if($request->role_id){
                $roles = Role::whereIn('id', $request->role_id)->get();
                $permission->syncRoles($roles);
            } else {
                foreach($permission->roles as $role){
                    $permission->removeRole($role);
                }
            }
        });
        return redirect(Session::get('requestReferrer'))->with('success', 'Permission has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->back()->with('success', 'Permission has been deleted.');
    }

    public function tableHeaders($request)
    {
        return [
            [
                'name' => '', 
                'width' => '1%',
            ], 
            [
                'name' => 'No.|created_at', 
                'class' => 'text-left pl-8', 
                'width' => '10%',
                'orderable' => true,
                'orderType' => $request->orderType
            ], 
            [
                'name' => 'Name|name',
                'class' => 'text-left pl-8',
                'orderable' => true,
                'orderType' => $request->orderType
            ],
            [
                'name' => 'Roles',
                'class' => 'text-left',
            ],
        ];
    }

    public function filterData($request)
    {
        $search = $request->search;
        $orderBy = $request->orderBy;
        $orderType = $request->orderType;
        
        $data = Permission::query();
        $data->when($search, function($query) use($search){
            return $query->where('name', 'like', '%'.$search.'%');
        })->when($orderBy, function($query) use($orderBy, $orderType){
            return $query->orderBy($orderBy, $orderType);
        });
        $data = $data->paginate(10);

        return $data;
    }
}