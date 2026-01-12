<?php

namespace App\Http\Controllers\DataBank;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $query = Service::with('provider');

        if (request()->has('search') && request()->filled('search')) {
            $search = request('search');

            $query->where(function ($q) use ($search) {
                $q->where('name_ar', 'LIKE', "%{$search}%")
                  ->orWhere('name_en', 'LIKE', "%{$search}%");
            });
        }

        $services  = $query->latest()->get();
        $providers = Provider::all();

        return view('components.DataBank.services.index', compact('services', 'providers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'name_ar'     => 'required|string',
            'name_en'     => 'required|string',
            'price'       => 'required|numeric',
            'price_unit'  => 'required|string',
            'capacity'    => 'nullable|integer',
            'description' => 'required|string',
            'image'       => 'required|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        Service::create($validated);
        return redirect()->route('databank.services.index')
                         ->with('success', 'تمت الإضافة بنجاح');
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $validated = $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'name_ar'     => 'required|string',
            'name_en'     => 'required|string',
            'price'       => 'required|numeric',
            'price_unit'  => 'required|string',
            'capacity'    => 'nullable|integer',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:2048', 
        ]);

        if ($request->hasFile('image')) {

            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            $validated['image'] = $request->file('image')->store('services', 'public');
        }

        $service->update($validated);
        return redirect()->route('databank.services.index')
                         ->with('success', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();
        return redirect()->route('databank.services.index')
                         ->with('success', 'تم الحذف بنجاح');
    }
}