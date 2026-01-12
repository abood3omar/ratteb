<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Provider;
use App\Models\Service;
use App\Models\ServiceBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewBookingNotification;
use Illuminate\Support\Facades\Notification;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query()->with(['provider', 'provider.category']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name_ar', 'LIKE', "%{$search}%")
                  ->orWhere('name_en', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('provider', function ($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        if ($request->filled('city')) {
            $query->whereHas('provider', function ($q) use ($request) {
                $q->where('city', $request->city);
            });
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $services = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::whereHas('providers.services')->get();
        $cities = Provider::whereHas('services')->distinct()->pluck('city');

        return view('components.front.services.index', compact('services', 'categories', 'cities'));
    }

    public function showBookingPage($id)
    {
        $service = Service::with('provider')->findOrFail($id);
        return view('components.front.services.book', compact('service'));
    }

    public function storeBooking(Request $request, $id)
    {
        $request->validate([
            'date'           => 'required|date|after:today',
            'notes'          => 'nullable|string',
            'quantity'       => 'nullable|integer|min:1',
            'guest_count'    => 'nullable|integer',
            'delivery_type'  => 'nullable|in:pickup,delivery',
            'address'        => 'required_if:delivery_type,delivery',
            'flower_type'    => 'nullable|string',
        ]);

        $service = Service::findOrFail($id);
        $deliveryCost = ($request->delivery_type == 'delivery') ? 5 : 0;
        $quantity     = $request->quantity ?? 1;
        $totalPrice   = ($service->price * $quantity) + $deliveryCost;

        $booking =
        ServiceBooking::create([
            'user_id'       => Auth::id(),
            'service_id'    => $service->id,
            'date'          => $request->date,
            'quantity'      => $quantity,
            'guest_count'   => $request->guest_count,
            'delivery_type' => $request->delivery_type,
            'address'       => $request->address,
            'flower_type'   => $request->flower_type,
            'notes'         => $request->notes,
            'total_price'   => $totalPrice,
            'status'        => 'pending',
        ]);

    $admins = User::where('RoleID', 1)->get(); 
    Notification::send($admins, new NewBookingNotification([
        'id' => $booking->id,
        'amount' => $booking->total_price
    ]));

        return redirect()->route('front.services.index')
                         ->with('success', 'تم طلب الخدمة بنجاح!');
    }
}