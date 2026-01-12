<?php

namespace App\Http\Controllers\DataBank;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('services')->latest()->paginate(10);
        $services = Service::all();

        return view('components.DataBank.packages.index', compact('packages', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar'     => 'required|string|max:255',
            'name_en'     => 'nullable|string|max:255',
            'price'       => 'required|numeric',
            'description' => 'required|string',
            'services'    => 'required|array|min:1',
            'image'       => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('packages', 'public');
        }

        $package = Package::create([
            'name_ar'     => $request->name_ar,
            'name_en'     => $request->name_en,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $imagePath,
        ]);

        if ($request->has('services')) {
            $package->services()->attach($request->services);
        }

        return redirect()->route('databank.packages.index')
                         ->with('success', 'تم إضافة الباقة بنجاح!');
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'name_ar'     => 'required|string|max:255',
            'name_en'     => 'nullable|string|max:255',
            'price'       => 'required|numeric',
            'description' => 'nullable|string',
            'services'    => 'required|array|min:1',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($package->image && Storage::disk('public')->exists($package->image)) {
                Storage::disk('public')->delete($package->image);
            }
            $package->image = $request->file('image')->store('packages', 'public');
        }

        $package->name_ar = $request->name_ar;
        $package->name_en = $request->name_en;
        $package->price = $request->price;
        $package->description = $request->description;
        $package->save();

        $package->services()->sync($request->services);

        return redirect()->route('databank.packages.index')
                         ->with('success', 'تم تعديل الباقة بنجاح!');
    }

    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->route('databank.packages.index')
                         ->with('success', 'تم حذف الباقة بنجاح');
    }
}