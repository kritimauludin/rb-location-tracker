<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Distribution;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        if(auth()->user()->role_id == 1){
            $users  = User::where('role_id', '!=', '1')->get();
        } elseif(auth()->user()->role_id == 2){
            $users  = User::where('role_id', '!=', '1')->where('role_id', 3)->with('customer_handle')->get();
        }

        return view('user.users', [
            'users' => $users,
        ]);
    }

    //controller ini hanya untuk melihat kinerja kurir dan generate report
    public function show(User $user){
        if ($user->role_id != 3) {
            return abort(403, 'Anda tidak memiliki akses kehalaman ini');
        }

        $distributions = Distribution::where('courier_code', $user->user_code)->with(['user_distribution'])->get();

        return view('user.courierPerformence', [
            'distributions' => $distributions,
            'courierData' => $user
        ]);
    }

    public function edit(User $user) {
        $roles  = Role::where('id', '!=', '4')->where('id', '!=', '1')->get();
        $data = [
            'user' => $user,
            'roles' => $roles
        ];

        if($user->role_id == 3){
            $allUserData = User::where('user_code', $user->user_code)->with('customer_handle')->get();
            $data['user'] = $allUserData[0];
            $data['customerHandle'] = $allUserData[0]['customer_handle'];
            $data['customers'] = Customer::where('courier_code', null)->get();
        }
        // dd($data);

        return view('user.update', $data);
    }

    public function update(Request $request, User $user){
        $validCustomer = $request->validate([
            'user_code' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'address' => 'max:255',
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
