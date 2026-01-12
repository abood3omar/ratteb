<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role')
            ->orderByRaw("CASE WHEN display_order IS NULL THEN 1 ELSE 0 END, display_order ASC, id ASC");

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('MobileNumber', 'like', "%{$search}%")
                  ->orWhereHas('role', function ($q) use ($search) {
                      $q->where('RoleName', 'like', "%{$search}%");
                  });
            });
        }

        $users   = $query->paginate(10)->appends(['search' => $search]);
        $total   = User::count();
        $showing = $users->count();

        return view('components.Security.users.index', compact('users', 'showing', 'total'));
    }

    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = Role::all();

        return view('components.Security.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'MobileNumber'  => 'required|string|max:50',
            'RoleID'        => 'nullable|exists:roles,RoleID',
            'display_order' => 'nullable|integer',
        ]);

        $user->update([
            'name'          => $request->name,
            'email'         => $request->email,
            'MobileNumber'  => $request->MobileNumber,
            'RoleID'        => $request->RoleID,
            'display_order' => $request->display_order,
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'تم تعديل بيانات المستخدم بنجاح!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'تم حذف المستخدم بنجاح!');
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('users.index')->with('success', 'تم تغيير كلمة المرور بنجاح!');
    }
}