<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NewBookingNotification extends Notification
{
    use Queueable;

    public $bookingData;

    public function __construct($bookingData)
    {
        $this->bookingData = $bookingData;
    }

    public function via(object $notifiable): array
    {
        return ['database']; 
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->bookingData['id'],
            'message' => 'يوجد طلب حجز جديد من: ' . Auth::user()->name,
            'link' => url('/admin/bookings?booking_id=' . $this->bookingData['id']), 
            'time' => now()
        ];
    }
}