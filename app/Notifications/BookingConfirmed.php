<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmed extends Notification
{
    use Queueable;

    protected $booking;

    // Inject booking data
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    // Which channels to send the notification through
    public function via($notifiable)
    {
        return ['mail', 'database']; // send via email & database
    }

    // Email content
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Booking Confirmed')
                    ->line('Your booking has been successfully confirmed.')
                    ->action('View Booking', url('/bookings/' . $this->booking->id))
                    ->line('Thank you for using our service!');
    }

    // Store in database
    public function toDatabase($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'message' => 'Your booking has been confirmed!',
        ];
    }
}