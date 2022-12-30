<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
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
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        Role::create($request->validated());
        return to_route('roles.index')->with('success', 'Role has been saved.');
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
       return view('role.edit');
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
        $role->update($request->validated());
        return to_route('roles.index')->with('success', 'Role has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return to_route('roles.index')->with('success', 'Role has been deleted.');
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