<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Distribution;
use App\Models\User;
use App\Models\UserDistribution;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $admins = User::where('role_id', '2')->get();
        $couriers = User::where('role_id', '3')->get();
        $customers = Customer::select('customer_name', 'join_date', 'expire_date', 'latitude', 'longitude', 'updated_at')->get();
        $recentDistributions = UserDistribution::whereDate('created_at', Carbon::today())->with(['customer', 'distribution'])->orderBy('updated_at', 'DESC')->take(10)->get();
        // dd($recentDistributions);

        //count
        $totalAdmin = count($admins);
        $totalCourier = count($couriers);
        $totalCustomer = count($customers);
        $totalDistributionToday = count($recentDistributions);

        return view('home', [
            'customers' => $customers,
            'totalAdmin' => $totalAdmin,
            'totalCourier' => $totalCourier,
            'totalCustomers' => $totalCustomer,
            'totalDistributionToday' => $totalDistributionToday,
            'recentDistributions' => $recentDistributions
        ]);
    }

    public function myProfile()
    {
        $user = User::where('id', auth()->user()->id)->with('role')->first();
        return view('my-profile', [
            'user' => $user
        ]);
    }

    public function updatePassword(Request $request)
    {
        # Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);


        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return redirect('/my-profile')->with("error", "Old Password Doesn't match!");
        }


        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect('/my-profile')->with("success", "Password changed successfully!");
    }

    public function updateProfile(Request $request, User $user){
        $userData = [
            'name' => 'required|max:255',
            'email' => 'required',
            'address' => 'max:255',
            'img_profile' => 'image|file',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ];

        $validatedUserData = $request->validate($userData);


        if ($request->img_profile) {
            if ($request->oldImage && $request->oldImage != 'assets/img/profile-img.jpg') {
                Storage::delete($request->oldImage);
            }
            $validatedUserData['img_profile'] = $request->file('img_profile')->store('img/user-profile');
        }

        User::where('id', $user->id)->update($validatedUserData);
        return redirect('/my-profile')->with('success', 'Profile has been edited!!');
    }
}
