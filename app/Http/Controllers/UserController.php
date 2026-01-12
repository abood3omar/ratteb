<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('components.User.index');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'MobileNumber' => 'required|string|max:50',
        ]);
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->MobileNumber = $request->MobileNumber;
        $user->save();

        return redirect()->back()->with('success', 'تم تحديث الملف الشخصي بنجاح!');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'كلمة المرور الحالية غير صحيحة.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'تم تغيير كلمة المرور بنجاح!');
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'password' => 'required',
        ]);
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'كلمة المرور غير صحيحة.');
        }

        $user->delete();
        Auth::logout(); 
        return redirect('/login')->with('success', 'تم حذف الحساب بنجاح!');
    }
}