<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(){
        $categories = DB::select('SELECT category.*
                                FROM category
                                WHERE row_delete = 0');
        return view("login",["categories"=>$categories]);
    }
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $customer = Customer::where('email', $email)->first();
        $user = User::where('email', $email)->first();
        if ($customer && Hash::check($password, $customer->password)){
            Auth::guard('customer')->login($customer);
            return redirect()->route('homepage');
        } elseif ($user && Hash::check($password, $user->password)){
            Auth::login($user);
            $checkRole = DB::select('SELECT role.role_name FROM user
                                    JOIN user_role ON user_role.user_id = user.user_id
                                    JOIN role ON role.role_id = user_role.role_id
                                    WHERE user.user_id = ?', [$user->user_id]);
            if ($checkRole[0]->role_name === "admin") {
                return redirect()->route('admin.homepage');
            } else {
                return redirect()->route('manage.homepage');
            }
        }
        return redirect()->route('login')->with('error', 'Invalid credentials');
    }
    public function logout(Request $request, HomepageController $homepageController){
        Auth::guard('customer')->logout();
        Auth::guard('web')->logout();
        
        return $homepageController->index();
    }
    
}

