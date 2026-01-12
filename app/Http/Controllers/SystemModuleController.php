<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Entity;
use App\Models\Module;
use Illuminate\Http\Request;

class SystemModuleController extends Controller
{
    public function index()
    {
      $pageModules  = Module::all(); 
      $pageActions  = Action::all();
      $pageEntities = Entity::with('module')->get();

      return view('components.Security.system-module.index', compact('pageModules', 'pageActions', 'pageEntities'));
    }

    public function addModule(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:modules,ModuleName',
        ], [
            'name.unique' => 'اسم الموديول موجود مسبقًا، يرجى اختيار اسم آخر.',
        ]);

        try {
            Module::create(['ModuleName' => $request->name]);

            return redirect()->back()->with('success', 'تم إضافة الموديول بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة الموديول: ' . $e->getMessage());
        }
    }

    public function editModule($id, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:modules,ModuleName,' . $id . ',ModuleID',
        ], [
            'name.unique' => 'اسم الموديول موجود مسبقًا، يرجى اختيار اسم آخر.',
        ]);

        try {
            Module::findOrFail($id)->update(['ModuleName' => $request->name]);

            return redirect()->back()->with('success', 'تم تعديل الموديول بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل الموديول: ' . $e->getMessage());
        }
    }

    public function deleteModule($id)
    {
        try {
            Module::findOrFail($id)->delete();
            return redirect()->back()->with('success', 'تم حذف الموديول وجميع البيانات المرتبطة بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف الموديول: ' . $e->getMessage());
        }
    }

    public function addAction(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:actions,ActionName',
        ], [
            'name.unique' => 'اسم الإجراء موجود مسبقًا، يرجى اختيار اسم آخر.',
        ]);

        try {
            Action::create(['ActionName' => $request->name]);

            return redirect()->back()->with('success', 'تم إضافة الإجراء بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة الإجراء: ' . $e->getMessage());
        }
    }

    public function editAction($id, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:actions,ActionName,' . $id . ',ActionID',
        ], [
            'name.unique' => 'اسم الإجراء موجود مسبقًا، يرجى اختيار اسم آخر.',
        ]);

        try {
            Action::findOrFail($id)->update(['ActionName' => $request->name]);

            return redirect()->back()->with('success', 'تم تعديل الإجراء بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل الإجراء: ' . $e->getMessage());
        }
    }

    public function deleteAction($id)
    {
        try {
            Action::findOrFail($id)->delete();

            return redirect()->back()->with('success', 'تم حذف الإجراء بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف الإجراء: ' . $e->getMessage());
        }
    }

    public function addEntity(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255|unique:entities,EntityName',
            'module_id' => 'required|exists:modules,ModuleID',
        ], [
            'name.unique'      => 'اسم الكيان موجود مسبقًا، يرجى اختيار اسم آخر.',
            'module_id.exists' => 'الموديول المختار غير موجود.',
        ]);

        try {
            Entity::create([
                'EntityName' => $request->name,
                'ModuleID'   => $request->module_id,
            ]);

            return redirect()->back()->with('success', 'تم إضافة الكيان بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة الكيان: ' . $e->getMessage());
        }
    }

    public function editEntity($id, Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255|unique:entities,EntityName,' . $id . ',EntityID',
            'module_id' => 'required|exists:modules,ModuleID',
        ], [
            'name.unique'      => 'اسم الكيان موجود مسبقًا، يرجى اختيار اسم آخر.',
            'module_id.exists' => 'الموديول المختار غير موجود.',
        ]);

        try {
            Entity::findOrFail($id)->update([
                'EntityName' => $request->name,
                'ModuleID'   => $request->module_id,
            ]);

            return redirect()->back()->with('success', 'تم تعديل الكيان بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تعديل الكيان: ' . $e->getMessage());
        }
    }

    public function deleteEntity($id)
    {
        try {
            Entity::findOrFail($id)->delete();

            return redirect()->back()->with('success', 'تم حذف الكيان بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء حذف الكيان: ' . $e->getMessage());
        }
    }

    public function updateEntityActions($id, Request $request)
    {
        try {
            $entity = Entity::findOrFail($id);
            $entity->actions()->sync($request->actions ?? []);

            return redirect()->back()->with('success', 'تم تحديث إجراءات الكيان بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث إجراءات الكيان: ' . $e->getMessage());
        }
    }
}