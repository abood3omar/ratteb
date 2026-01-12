<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewBookingNotification;
use Illuminate\Support\Facades\Notification;

class UserPackageController extends Controller
{
    public function index()
    {
        $packages = Package::with('services')->latest()->get();
        return view('components.front.packages.index', compact('packages'));
    }

    public function showBookingPage($id)
    {
        $package = Package::with('services')->findOrFail($id);
        return view('components.front.packages.book', compact('package'));
    }

    public function storeBooking(Request $request, $id)
    {
        $request->validate([
            'date'           => 'required|date|after:today',
            'notes'          => 'nullable|string',
            'guest_count'    => 'nullable|integer',
            'delivery_type'  => 'required|in:pickup,delivery',
            'address'        => 'required_if:delivery_type,delivery',
            'extra_details'  => 'nullable|string',
        ]);

        $package = Package::findOrFail($id);
        $deliveryCost = ($request->delivery_type == 'delivery') ? 5 : 0;
        $totalPrice   = $package->price + $deliveryCost;

        $booking =
        PackageBooking::create([
            'user_id'       => Auth::id(),
            'package_id'    => $package->id,
            'date'          => $request->date,
            'notes'         => $request->notes,
            'guest_count'   => $request->guest_count,
            'delivery_type' => $request->delivery_type,
            'address'       => $request->address,
            'extra_details' => $request->extra_details,
            'total_price'   => $totalPrice,
            'status'        => 'pending',
        ]);

        $admins = User::where('RoleID', 1)->get();

        Notification::send($admins, new NewBookingNotification([
         'id' => $booking->id,
         'amount' => $booking->total_price
        ]));

        return redirect()->route('components.front.bookings.index')
                         ->with('success', 'تم حجز الباقة بنجاح!');
    }
}