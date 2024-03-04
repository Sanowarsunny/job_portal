<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function registerPage(){
        return view('front.account.register');
    }

   
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|same:cpassword',
            'cpassword' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->toArray()
            ], 422);
        }else {
            // Hash the password
            $hashedPassword = Hash::make($request->password);
        
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $hashedPassword,
            ]);
        
            session()->flash('success','You have register successfully.');
            return response()->json([
                'status' => true,
                'errors' => []
            ],200);
        }
        
    }







    public function loginPage(){
        return view('front.account.login');
    }
}
