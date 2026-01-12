<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\PackageBooking;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $eventBookings = Booking::with(['items.service.provider'])
            ->where('user_id', $userId)
            ->get()
            ->map(function ($booking) {
                $booking->type = 'event';
                $booking->display_name = $booking->occasion_type;
                return $booking;
            });

        $packageBookings = PackageBooking::with(['package.services.provider'])
            ->where('user_id', $userId)
            ->get()
            ->map(function ($booking) {
                $booking->type = 'package';
                $booking->display_name = $booking->package->name_ar;
                return $booking;
            });

        $serviceBookings = ServiceBooking::with(['service.provider'])
            ->where('user_id', $userId)
            ->get()
            ->map(function ($booking) {
                $booking->type = 'service';
                $booking->display_name = $booking->service->name_ar;
                return $booking;
            });

        $allBookings = $eventBookings
            ->concat($packageBookings)
            ->concat($serviceBookings)
            ->sortByDesc('created_at');

        return view('components.User.bookings', compact('allBookings'));
    }

    public function cancel(Request $request)
    {
        $request->validate([
            'id'   => 'required|integer',
            'type' => 'required|in:event,package,service',
        ]);
        $userId  = Auth::id();
        $booking = null;

        switch ($request->type) {
            case 'event':
                $booking = Booking::where('user_id', $userId)->find($request->id);
                break;
            case 'package':
                $booking = PackageBooking::where('user_id', $userId)->find($request->id);
                break;
            case 'service':
                $booking = ServiceBooking::where('user_id', $userId)->find($request->id);
                break;
        }

        if ($booking && $booking->status === 'pending') {
            $booking->delete();
            return back()->with('success', 'تم إلغاء الحجز بنجاح.');
        }

        return back()->with('error', 'عذراً، لا يمكن إلغاء هذا الحجز.');
    }

    public function uploadReceipt(Request $request)
    {
       $request->validate([
        'id' => 'required',
        'type' => 'required|in:event,package,service',
        'receipt' => 'required|image|max:2048',
       ]);

       $booking = null;
       $userId = Auth::id();

       if ($request->type == 'event') {
         $booking = Booking::where('user_id', $userId)->find($request->id);
       } elseif($request->type == 'package') {
         $booking = PackageBooking::where('user_id', $userId)->find($request->id);
       } elseif($request->type == 'service') {
         $booking = ServiceBooking::where('user_id', $userId)->find($request->id);
       }

       if($booking) {
        $path = $request->file('receipt')->store('receipts', 'public');
        $booking->update([
            'payment_receipt' => $path,
            'deposit_amount' => $booking->total_price * 0.20,
        ]);
        return back()->with('success', 'تم رفع الوصل بنجاح! بانتظار تأكيد الإدارة.');
        }

      return back()->with('error', 'حدث خطأ أثناء رفع الوصل.');
    } 

}