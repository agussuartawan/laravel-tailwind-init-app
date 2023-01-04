<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use PhpParser\Node\Stmt\Return_;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $headers = $this->tableHeaders($request);
        $data = $this->filterData($request);

        return view('role.index', compact('data', 'headers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('requestReferrer', URL::previous());
        
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        DB::transaction(function() use($request){
            $role = Role::create($request->validated());

            $permissions = Permission::whereIn('id', $request->permission_id)->get();
            $role->syncPermissions($permissions);
        });
        return redirect(Session::get('requestReferrer'))->with('success', 'Role has been saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if($role->name == User::SUPER_ADMIN){
            abort(403);
        }
        Session::put('requestReferrer', URL::previous());
        
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('role.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        if($role->name == User::SUPER_ADMIN){
            abort(403);
        }
        DB::transaction(function() use($request, $role){
            $role->update($request->validated());

            if($request->permission_id){
                $permissions = Permission::whereIn('id', $request->permission_id)->get();
                $role->syncPermissions($permissions);
            } else {
                $role->revokePermissionTo($role->permissions);
            }
        });
        return redirect(Session::get('requestReferrer'))->with('success', 'Role has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if($role->name == User::SUPER_ADMIN){
            abort(403);
        }
        $role->delete();
        return redirect()->back()->with('success', 'Role has been deleted.');
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
                'name' => 'Permissions',
                'class' => 'text-left',
            ],
        ];
    }

    public function filterData($request)
    {
        $search = $request->search;
        $orderBy = $request->orderBy;
        $orderType = $request->orderType;
        
        $data = Role::query();
        $data->when($search, function($query) use($search){
            return $query->where('name', 'like', '%'.$search.'%');
        })->when($orderBy, function($query) use($orderBy, $orderType){
            return $query->orderBy($orderBy, $orderType);
        });
        $data = $data->paginate(10);

        return $data;
    }
}