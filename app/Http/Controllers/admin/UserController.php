<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function userListPage() {
        $users = User::where('role','user')->orderBy('created_at','DESC')->paginate(5);
        return view('backend.admin.users.userListPage',[
            'users' => $users
        ]);
    }

    public function userEditPage($id) {
        $user = User::findOrFail($id);
        
        return view('backend.admin.users.userEditPage',[
            'user' => $user
        ]);
    }

    public function userupdate($id, Request $request) {
        
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,'.$id.',id'
        ]);


        if ($validator->passes()) {

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success','User information updated successfully.');

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

    public function userDelete(Request $request){
        $id = $request->id;
    
        $user = User::find($id);
    
        if ($user == null) {
            session()->flash('error','User not found');
            return response()->json([
                'status' => false,
            ]);
        }
    
        // Delete user's image from public folder if it exists
        if (!empty($user->image)) {
            $imagePath = public_path('profile_image/' . $user->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
        // Delete user from the database
        $user->delete();
    
        session()->flash('success','User deleted successfully');
        return response()->json([
            'status' => true,
        ]);
    }
    
}
