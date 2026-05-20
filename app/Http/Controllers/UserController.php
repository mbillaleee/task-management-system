<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Employee;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'role' => 'required',
            'status' => 'nullable|in:1,0',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->status = $request->input('status');

        if ($request->password) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $name = time() . '_hero.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('profile/' . $name, File::get($file));
            $user->profile = $name;
        }

        $user->save();

        // Single role assign
        $user->assignRole($request->input('role'));

        return redirect()->route('admin.users.index')
                        ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        $userRole = $user->roles->pluck('name','name')->all();
        return view('admin.users.show',compact('user','userRole'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('admin.users.edit',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'role' => 'required',
            'status' => 'nullable|in:1,0',
        ]);
        
        // dd('ok', $request->all());
    
  
    
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile')) {
            if ($user->profile && Storage::disk('public')->exists('profile/' . $user->profile)) {
                Storage::disk('public')->delete('profile/' . $user->profile);
            }
            $file = $request->file('profile');
            $name = time() . '_hero.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('profile/' . $name, File::get($file));
            $user->profile = $name;
        }

        $user->save();
        
        // dd('ok');

        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('role'));


        return redirect()->route('admin.users.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::find($id)->delete();
        return redirect()->route('admin.users.index')
                        ->with('success','User deleted successfully');
    }
}
