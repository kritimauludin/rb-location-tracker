<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users  = User::where('role_id', '!=', '1')->get();

        return view('user.users', [
            'users' => $users,
        ]);
    }

    public function show(User $user){

    }

    public function edit(User $user) {
        $roles  = Role::where('id', '!=', '4')->where('id', '!=', '1')->get();
        return view('user.update', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, User $user){
        $validCustomer = $request->validate([
            'user_code' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'address' => 'required',
            'role_id' => 'max:255'
        ]);

        User::where('id', $user->id)->update($validCustomer);

        return redirect('/user')->with('success', 'Data pengguna berhasil diubah !');
    }
    public function destroy(User $user){
        User::where('user_code', $user->user_code)->delete();
        return redirect('/user')->with('success', 'Pengguna berhasil dihapus!');
    }
}
