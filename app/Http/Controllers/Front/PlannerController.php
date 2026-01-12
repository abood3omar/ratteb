<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\OccasionType;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewBookingNotification;
use Illuminate\Support\Facades\Notification;

class PlannerController extends Controller
{
    public function index()
    {
        $occasions = OccasionType::withCount('categories')->get();
        return view('components.front.planner.index', compact('occasions'));
    }

    public function show($slug)
    {
        $occasion = OccasionType::where('slug', $slug)
            ->with(['categories' => function ($q) {
                $q->orderBy('display_order')
                  ->with(['providers.services']);
            }])
            ->firstOrFail();

        $servicesLookup = [];
        foreach ($occasion->categories as $category) {
            foreach ($category->providers as $provider) {
                foreach ($provider->services as $service) {
                    $servicesLookup[$service->id] = [
                        'id'          => $service->id,
                        'name'        => $service->name_ar,
                        'description' => $service->description,
                        'capacity'    => $service->capacity,
                        'price'       => (int) $service->price,
                        'price_unit'  => $service->price_unit,
                        'image'       => $service->image ? asset('storage/' . $service->image) : null,
                        'provider'    => $provider->name_ar,
                        'cat_name'    => $category->name_ar,
                    ];
                }
            }
        }

        return view('components.front.planner.wizard', compact('occasion', 'servicesLookup'));
    }


    public function store(Request $request)
    {

        if (!Auth::check()) {
            return response()->json([
            'success'      => false,
            'message'      => 'يرجى تسجيل الدخول للمتابعة',
            'redirect_url' => route('login'),
            ]);
        }

        $request->validate([
         'occasion_slug'  => 'required|string',
         'event_date'     => 'required|date|after:today',
          'event_time'     => 'required',
         'selections'     => 'required|array',
         'guest_count'    => 'nullable|integer',
         'delivery_type'  => 'nullable|in:pickup,delivery',
         'address'        => 'required_if:delivery_type,delivery',
         'extra_details'  => 'nullable|string',
        ]);

        try {
            $bookingId = DB::transaction(function () use ($request) {
            $serviceIds = array_values($request->selections);
            $services   = Service::whereIn('id', $serviceIds)->get();
            $totalPrice = $services->sum('price');

            $booking = Booking::create([
                'user_id'       => Auth::id(), 
                'occasion_type' => $request->occasion_slug,
                'event_date'    => $request->event_date,
                'event_time'    => $request->event_time,
                'guest_count'   => $request->guest_count,
                'delivery_type' => $request->delivery_type,
                'address'       => $request->address,
                'extra_details' => $request->extra_details,
                'total_price'   => $totalPrice,
                'status'        => 'pending',
            ]);

            $admins = User::where('RoleID', 1)->get();
            Notification::send($admins, new NewBookingNotification([
                'id'     => $booking->id,
                'amount' => $booking->total_price
            ]));

            foreach ($services as $service) {
                BookingItem::create([
                    'booking_id' => $booking->id,
                    'service_id' => $service->id,
                    'price'      => $service->price,
                ]);
            }
            return $booking->id;
          });

            return response()->json([
            'success'      => true,
            'message'      => 'تم الحجز بنجاح!',
            'redirect_url' => route('components.front.bookings.index'),
            ]);

        } catch (\Exception $e) {
             return response()->json([
            'success' => false,
            'message' => 'حدث خطأ أثناء الحجز: ' . $e->getMessage(),
            ], 500);
        }
    }
}