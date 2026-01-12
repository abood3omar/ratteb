<?php

namespace App\Http\Controllers;
use App\Models\Action;
use App\Models\Entity;
use App\Models\Module;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleRightsController extends Controller
{
    public function index()
    {
        $roles = Role::with(['permissions', 'actions'])->get();
        $pageModules  = Module::all(); 
        $pageActions  = Action::all();
        $pageEntities = Action::all();

        return view('components.Security.role-rights.index', compact('roles', 'pageModules', 'pageActions', 'pageEntities'));
    }

    public function addRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,RoleName',
        ]);

        try {
            Role::create(['RoleName' => $request->name]);

            return redirect()->back()->with('success', 'تم إضافة الدور بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'فشل في إضافة الدور: ' . $e->getMessage());
        }
    }

    public function editRole($id, Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:roles,RoleName,' . $id . ',RoleID',
            'permissions' => 'nullable|array',
        ]);

        try {
            $role = Role::findOrFail($id);
            $role->update(['RoleName' => $request->name]);
            $role->permissions()->sync([]);

            if ($request->has('permissions')) {
                foreach ($request->permissions as $entityId => $actionIds) {
                    $actionIds = (array) $actionIds;
                    foreach ($actionIds as $actionId) {
                        $role->permissions()->attach($entityId, ['action_id' => $actionId]);
                    }
                }
            }

            return redirect()->back()->with('success', 'تم تعديل الدور بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'فشل في تعديل الدور: ' . $e->getMessage());
        }
    }

    public function deleteRole($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->permissions()->detach();
            $role->delete();

            return redirect()->back()->with('success', 'تم حذف الدور بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'فشل في حذف الدور: ' . $e->getMessage());
        }
    }
}