<?php

namespace App\Http\Controllers\DataBank;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OccasionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OccasionTypeController extends Controller
{
    public function index()
    {
        $occasions  = OccasionType::with('categories')->get();
        $categories = Category::all();

        return view('components.DataBank.occasions.index', compact('occasions', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar'     => 'required|string',
            'name_en'     => 'required|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'categories'  => 'required|array',
            'categories.*'=> 'exists:categories,id',
        ]);

        $validated['slug'] = Str::slug($validated['name_en']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('occasions', 'public');
        }

        $occasion = OccasionType::create($validated);
        $occasion->categories()->sync($request->categories);

        return redirect()->back()->with('success', 'تمت الإضافة بنجاح');
    }

    public function update(Request $request, $id)
    {
        $occasion = OccasionType::findOrFail($id);

        $validated = $request->validate([
            'name_ar'     => 'required|string',
            'name_en'     => 'required|string',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'categories'  => 'required|array',
            'categories.*'=> 'exists:categories,id',
        ]);

        $validated['slug'] = Str::slug($validated['name_en']);

        if ($request->hasFile('image')) {

            if ($occasion->image) {
                Storage::disk('public')->delete($occasion->image);
            }

            $validated['image'] = $request->file('image')->store('occasions', 'public');
        }

        $occasion->update($validated);
        $occasion->categories()->sync($request->categories);

        return redirect()->back()->with('success', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $occasion = OccasionType::findOrFail($id);

        if ($occasion->image) {
            Storage::disk('public')->delete($occasion->image);
        }

        $occasion->delete();

        return redirect()->back()->with('success', 'تم الحذف بنجاح');
    }
}