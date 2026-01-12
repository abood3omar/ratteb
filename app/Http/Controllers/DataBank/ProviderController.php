<?php

namespace App\Http\Controllers\DataBank;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{

    public function index()
    {
        $query = Provider::with('category');

        if (request()->has('search') && request()->filled('search')) {
            $search = request('search');

            $query->where(function ($q) use ($search) {
                $q->where('name_ar', 'LIKE', "%{$search}%")
                  ->orWhere('name_en', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $providers = $query->latest()->get();
        $categories = Category::all();

        return view('components.DataBank.providers.index', compact('providers', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name_ar'        => 'required|string',
            'name_en'        => 'required|string',
            'phone'          => 'required|string',
            'email'          => 'nullable|email',
            'city'           => 'required|string',
            'location_link'  => 'nullable|url',
        ]);

        $validated['is_freelance'] = $request->has('is_freelance') ? 1 : 0;

        Provider::create($validated);
        return redirect()->route('databank.providers.index')
                         ->with('success', 'تم إضافة المزود بنجاح');
    }

    public function update(Request $request, $id)
    {
        $provider = Provider::findOrFail($id);

        $validated = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'name_ar'        => 'required|string',
            'name_en'        => 'required|string',
            'phone'          => 'required|string',
            'email'          => 'nullable|email',
            'city'           => 'required|string',
            'location_link'  => 'nullable|url',
        ]);

        $validated['is_freelance'] = $request->has('is_freelance') ? 1 : 0;
        $provider->update($validated);

        return redirect()->route('databank.providers.index')
                         ->with('success', 'تم تعديل المزود بنجاح');
    }

    public function destroy($id)
    {
        Provider::findOrFail($id)->delete();

        return redirect()->route('databank.providers.index')
                         ->with('success', 'تم الحذف بنجاح');
    }
}