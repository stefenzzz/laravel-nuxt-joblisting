<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::with('role')->latest()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('role');

        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        
        $fields = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'nullable|exists:roles,code',
            'status' => 'required|in:active,pending',
            'password' => $request->filled('password') ? 'confirmed' : 'nullable',
        ]);
        
        // update role
        if($request->role !== $user->role->code){
            $role = Role::query()->where('code', $request->role)->first();
            $user->role_id = $role->id;
            $user->save(); 
        }
        unset($fields['role']);
        // re assign password if request password is empty
        $fields['password'] = $request->password ? Hash::make( $request->password ) : $user->password;

        $user->fill($fields);
        if($user->isDirty()) {
            $user->save(); // save changes
        }

        return response()->json([], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
