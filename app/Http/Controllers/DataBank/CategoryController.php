<?php

namespace App\Http\Controllers\DataBank;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('search') && $request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('name_ar', 'LIKE', "%{$search}%")
                  ->orWhere('name_en', 'LIKE', "%{$search}%");
            });
        }

        $categories = $query->withCount('providers')
                            ->orderBy('display_order', 'asc')
                            ->get();

        return view('components.DataBank.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar'      => 'required|string|max:255',
            'name_en'      => 'required|string|max:255',
            'display_order'=> 'required|integer',
        ]);

        Category::create($validated);

        return redirect()->route('databank.categories.index')
                         ->with('success', 'تم إضافة التصنيف بنجاح');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name_ar'      => 'required|string|max:255',
            'name_en'      => 'required|string|max:255',
            'display_order'=> 'required|integer',
        ]);

        $category->update($validated);

        return redirect()->route('databank.categories.index')
                         ->with('success', 'تم تعديل التصنيف بنجاح');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('databank.categories.index')
                         ->with('success', 'تم حذف التصنيف بنجاح');
    }
}