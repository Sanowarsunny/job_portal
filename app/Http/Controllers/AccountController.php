<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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

    //login page and login function
    public function loginPage(){
        return view('front.account.login');
    }

    public function logincheck(Request $request){
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if ($validator->passes()) {

            if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password ])){
                return redirect()->route('profilePage');
            }
            else{
                return redirect()->route('login')->with('error','Email/Password is worng');

            }
        }
        else {
            return redirect()->route('login')
                    ->withErrors($validator)
                    ->withInput($request->only('email'));
            
        }
    }

    public function logout(){

        Auth::logout();
        return redirect()->route('login');
    }
    
    public function profilePage(){

        $id = Auth::user()->id;
        // dd($id);
        $user = User::where('id',$id)->first();

        return view('front.account.profile',[
            'user'=>$user
        ]);
    }

    public function updateProfile(Request $request){

        $id = Auth::user()->id;
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'name' => 'required|min:4|max:30',
        ]);

        if ($validator->passes()) {

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;

            $user->save();
            session()->flash('success','Your Profile Updated successfully.');
            return redirect()->route('profilePage');
            
        }
        else {
            return redirect()->route('profilePage')
            ->withErrors($validator);
        }
    }

    public function profileImage(Request $request){

        $id = Auth::user()->id;
        
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
        ]);

        if ($validator->passes()) {

            $image = $request->image;
            $ext = $image->getClientOriginalExtension(); // Get the file extension

            // Generate a unique filename
            $imageName = $id . '_' . time() . '.' . $ext;

            // Store the image in the storage directory
            $image->move(public_path('/profile_image/'),$imageName);

            //old image delete
            File::delete(public_path('/profile_image/').Auth::user()->image);
            // Update the user's profile image path in the database
            User::where('id',$id)->update(['image'=>$imageName]);
            
            session()->flash('success', 'Image updated successfully.');

            return redirect()->route('profilePage');
            
            
        }
        else {
            return redirect()->route('profilePage')
            ->withErrors($validator);
        }
    }


    //end
}
