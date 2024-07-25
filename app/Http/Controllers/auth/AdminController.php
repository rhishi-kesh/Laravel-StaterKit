<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function adminLogin(){

        if (!Auth::check()) {
            return view('auth/adminlogin');
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function loginPost(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::check()) {
            $user = User::where('email', $request->email)->first();
            if($user->status == 0) {
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();

                    return to_route('dashboard');
                }
            }else{
                return back()->withErrors([
                    'error' => 'Your Account Deactived',
                ]);
            }
        }else{
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'error' => 'Email or Password is invalid',
        ]);
    }

    public function logout(Request $request) {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('adminLogin');
    }

    public function register() {
        return view('backend.pages.register.register');
    }

    public function registerPost(Request $request) {

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|same:Cpassword',
        ]);

        $done = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 1,
            'created_at' => Carbon::now(),
        ]);


        if($done){
            return back()->with('success', 'User Added');
        }else {
            return back()->with('error', 'User Not Added!');
        }
    }

    public function users() {
        $users = User::where('role', 1)->paginate();
        return view('backend.pages.user.user', compact('users'));
    }

    public function userDelete($id) {
        $user = User::findOrFail($id);
        if($user){
            $image_path = public_path('storage\\' . $user->profile);
            $user->delete();
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            return back()->with('error', 'Data Deleted Successfull');
        }
    }

    public function userStatus($id) {
        $user = User::where('id', $id)->first();

        if($user->status == 0){
            $user->update([
                'status' => '1',
                'updated_at' => Carbon::now()
            ]);
        }else{
            $user->update([
                'status' => '0',
                'updated_at' => Carbon::now()
            ]);
        }
        return response()->json('Status Changed!');
    }

    public function profile() {
        return view('backend.pages.profile.profile');
    }

    public function changeInformation(Request $request, $id) {

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $done = User::findOrFail($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'updated_at' => Carbon::now(),
        ]);

        if($done){
            return back()->with('success', 'Information Updated');
        }else {
            return back()->with('error', 'Information Not Update!');
        }
    }

    public function changePassword(Request $request, $id) {

        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:8', 'same:password_confirmation']
        ]);

        if(Hash::check($request->current_password, Auth::user()->password)){
            $user = User::findOrFail($id);
            $user->password = Hash::make($request->password);
            $user->update();
            return back()->with('successp', 'Password Changed');
        }else{
            return back()->with('old','Old Password Not Correct');
        }
    }

    public function changeProfile(Request $request, $id) {

        $validated = $request->validate([
            'profile_image' => ['required', 'image', 'mimes:jpg,png,jpeg']
        ]);

        $user = User::findOrFail($id);
        $oldImage = $user->profile;
        $fileName = "";
        $image_path = public_path('storage\\' . $oldImage);
        if(!empty($request->profile_image)){
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $fileName = $request->profile_image->store('profile', 'public');
        } else {
            $fileName = $oldImage;
        }
        $user->profile = $fileName;
        $user->updated_at = Carbon::now();
        $user->update();

        if($user){
            return back()->with('successprofile', 'Profile Updated');
        }else {
            return back()->with('errorprofile', 'Profile Not Update!');
        }
    }
}
