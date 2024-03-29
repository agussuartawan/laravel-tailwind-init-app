<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;

class UserController extends Controller
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
        return view('user.index', compact('data', 'headers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('requestReferrer', URL::previous());
        
        $roles = Role::where('name', '!=', User::SUPER_ADMIN)->orderBy('name', 'asc')->get();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        DB::transaction(function() use($request){
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            $user = User::create($validated);
            
            $role = Role::findOrFail($request->role_id);
            $user->assignRole($role);
        });
        return redirect(Session::get('requestReferrer'))->with('success', 'User has been saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        Session::put('requestReferrer', URL::previous());
        
        $roles = Role::where('name', '!=', User::SUPER_ADMIN)->orderBy('name', 'asc')->get();
        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        DB::transaction(function() use($request, $user){
            $user->update($request->validated());

            $role = Role::findOrFail($request->role_id);
            $user->syncRoles($role);
        });
        return redirect(Session::get('requestReferrer'))->with('success', 'User has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User has been deleted.');
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
                'class' => 'text-left',
                'orderable' => true,
                'orderType' => $request->orderType
            ], 
            [
                'name' => 'Email|email', 
                'class' => 'text-left',
                'orderable' => true,
                'orderType' => $request->orderType
            ]
        ];
    }

    public function filterData($request)
    {
        $search = $request->search;
        $orderBy = $request->orderBy;
        $orderType = $request->orderType;

        $data = User::where('name', '!=', User::SUPER_ADMIN);
        $data->when($search, function($query) use($search){
            return $query->where('name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%');
        })->when($orderBy, function($query) use($orderBy, $orderType){
            return $query->orderBy($orderBy, $orderType);
        });

        $data = $data->paginate(10);
        
        return $data;
    }

    public function getPermissionList(Request $request)
    {
        if($request->role_id){
            return Role::with(['permissions' => function($query){
                    $query->select('name');
                }])->select('id', 'name')->where('id', $request->role_id)->orderBy('name', 'asc')->get();
        }
        return [];
    }
}