<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'     => ['required', 'string', Password::min(8), 'confirmed'],
            'MobileNumber' => ['required', 'string', 'max:50'],
        ], [
            'name.required'         => 'حقل الاسم مطلوب.',
            'email.required'        => 'حقل البريد الإلكتروني مطلوب.',
            'email.email'           => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.unique'          => 'هذا البريد الإلكتروني مستخدم بالفعل.',
            'password.required'     => 'حقل كلمة المرور مطلوب.',
            'password.min'          => 'يجب أن تكون كلمة المرور 8 أحرف على الأقل.',
            'password.confirmed'    => 'تأكيد كلمة المرور غير متطابق.',
            'MobileNumber.required' => 'حقل رقم الهاتف مطلوب.',
        ]);

        $role = Role::where('RoleName', 'user')->firstOrFail();
        User::create([
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'password'     => Hash::make($validated['password']),
            'MobileNumber' => $validated['MobileNumber'],
            'RoleID'       => $role->RoleID,
        ]);

        return redirect()->route('login')
                         ->with('success', 'تم إنشاء الحساب بنجاح.');
    }
}