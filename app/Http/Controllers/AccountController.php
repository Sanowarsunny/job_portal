<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class AccountController extends Controller
{
    public function registerPage(){
        return view('front.account.register');
    }

    public function register(Request $request) {
       
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if ($validator->passes()) {
            // Hash the password
            $hashedPassword = Hash::make($request->password);
            
            // Set default role to 'user' if not provided
            $role = $request->input('role', 'user');

            // Create the user with provided data
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $hashedPassword,
                'role' => $role, // Assign the role
            ]);

            session()->flash('success','You have registerd successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
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










    // public function updateProfile(Request $request){

    //     $id = Auth::user()->id;
        
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email|unique:users,email,'.$id.',id',
    //         'name' => 'required|min:4|max:30',
    //         'cv' => Auth::user()->role === 'user' ? 
    //                     'required|file|mimes:pdf,doc,docx|max:5000' 
    //                     :'nullable|file|mimes:pdf,doc,docx|max:5000',
    //     ]);

    //     if ($validator->passes()) {

    //         $user = User::find($id);
    //         $user->name = $request->name;
    //         $user->email = $request->email;
    //         $user->designation = $request->designation;
    //         $user->mobile = $request->mobile;
            
    //         // Handle CV file upload if it exists
    //         if ($request->hasFile('cv')) {
    //             $cvFile = $request->file('cv');
    //             $cvPath = $cvFile->move(public_path('upload_cv'), $cvFile->getClientOriginalName());
    //             $user->cv = $cvPath->getPathname(); // Save file path
    //         }

    //         $user->save();
    //         session()->flash('success','Your Profile Updated successfully.');
    //         return redirect()->route('profilePage');
            
    //     }
    //     else {
    //         return redirect()->route('profilePage')
    //         ->withErrors($validator);
    //     }
    // }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
    
        // Define validation rules
        $rules = [
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'name' => 'required|min:4|max:30',
        ];
    
        // Check if user has a CV file already
        $user = User::find($id);
        $hasCV = !is_null($user->cv);
    
        // If no CV file exists, require the CV field
        if (!$hasCV || $request->hasFile('cv')) {
            $rules['cv'] = 'required|file|mimes:pdf,doc,docx|max:5000';
        }
    
        // Validate the request data
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->passes()) {
            // Update user profile data
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;


            // Handle CV file upload if it exists
            if ($request->hasFile('cv')) {


                $cvFile = $request->file('cv');

            
            $name = pathinfo($cvFile->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = $cvFile->getClientOriginalExtension(); 

            // Generate a unique filename
            $cvName = $id . $name . '.' . $ext;

            // Store the image in the storage directory
            $cvFile->move(public_path('/upload_cv/'),$cvName);
            //old image delete
            File::delete(public_path('/upload_cv/').Auth::user()->cv);
            
            $user->cv = $cvName; 
            
            }

            $user->save();
    
            session()->flash('success', 'Your Profile Updated successfully.');
            return redirect()->route('profilePage');
        } else {
            // Validation failed, redirect back with errors
            return redirect()->route('profilePage')->withErrors($validator);
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

    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:4',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        if (Hash::check($request->old_password, Auth::user()->password) == false){
            session()->flash('error','Your old password is incorrect.');
            return response()->json([
                'status' => true                
            ]);
        }


        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->new_password);  
        $user->save();

        session()->flash('success','Password updated successfully.');
        return response()->json([
            'status' => true                
        ]);

    }
    //end


    //forgetPasswordPage
    public function forgetPasswordPage(){
        return view('front.account.forgetPasswordPage');
    }

    public function forgetPassword(Request $request) {

        $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email'
        ]);
        if ($validator->fails()) {
            return redirect()->route('forgetPasswordPage')->withInput()->withErrors($validator);
        }

        $token = Str::random(40);

        DB::table('password_reset_tokens')->where('email',$request->email)->delete();

        DB::table('password_reset_tokens')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at'=>now()
        ]);

        // Send Email here
        $user = User::where('email', $request->email)->first();
        $mailData = [
            'token' => $token,
            'user' => $user,
            'subject' => 'Please Change your Password!!!!!'
        ];

        Mail::to($request->email)->send(new ResetPasswordEmail($mailData));
        
        return redirect()->route('forgetPasswordPage')->with('success','Reset password in your mail');

    }

    public function resetPasswordPage($tokenString){

        $token = DB::table('password_reset_tokens')->where('token', $tokenString)->first();

        if ($token == null) {
        return redirect()->route('forgetPasswordPage')->with('error', 'Invalid token.');
        }
        return view('front.account.resetPassPage',[
            'tokenString'=>$tokenString
        ]);

    }

    public function resetPassword(Request $request){

        $token = DB::table('password_reset_tokens')->where('token', $request->token)->first();
        if ($token == null) {
        return redirect()->route('forgetPasswordPage')->with('error', 'Invalid token.');
        }
        $validator = Validator:: make($request->all(), [
        'new_password' => 'required|min:4',
        'confirm_password' => 'required|same:new_password'
        ]);
        if ($validator->fails()) {
            return redirect()->route('resetPasswordPage', $request->token)->withErrors($validator);
        }

        User::where('email',$token->email)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('login')->with('success','Reset Password updated successfully.');

    }
    
        
}
