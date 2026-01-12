<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; 
use App\Models\PackageBooking; 
use App\Models\ServiceBooking; 
use Illuminate\Support\Facades\Auth;

class AdminBookingController extends Controller
{
    public function index()
    {
         if (Request()->has('notify_id')) {
            $notification = Auth::user()->notifications()->where('id', Request()->query('notify_id'))->first();
            if ($notification) {
              $notification->markAsRead();
            }
          }
 
          $eventBookings = Booking::with(['user'])->latest()->get()->map(fn($i) => $i->setAttribute('type', 'event'));
          $packageBookings = PackageBooking::with(['user', 'package'])->latest()->get()->map(fn($i) => $i->setAttribute('type', 'package'));
          $serviceBookings = ServiceBooking::with(['user', 'service'])->latest()->get()->map(fn($i) => $i->setAttribute('type', 'service'));
          $bookings = $eventBookings->concat($packageBookings)->concat($serviceBookings)->sortByDesc('created_at');
          $targetBookingId = Request()->query('booking_id'); 

          return view('components.admin.bookings.index', compact('bookings', 'targetBookingId'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'type' => 'required|in:event,package,service',
            'status' => 'required',
        ]);

        $booking = null;
        if ($request->type == 'event') $booking = Booking::find($request->id);
        elseif ($request->type == 'package') $booking = PackageBooking::find($request->id);
        elseif ($request->type == 'service') $booking = ServiceBooking::find($request->id);

        if ($booking) {
            $booking->update(['status' => $request->status]);
            return back()->with('success', 'تم تحديث الحالة بنجاح');
        }
        return back()->with('error', 'الحجز غير موجود');
    }

}