<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Booking $booking
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $this->booking->loadMissing(['service', 'staff']);

        return (new MailMessage)
            ->subject('Booking Created #'.$this->booking->id)
            ->greeting('Hello '.$notifiable->name.',')
            ->line('Your booking has been created successfully.')
            ->line('Booking ID: '.$this->booking->id)
            ->line('Service: '.($this->booking->service?->name ?? '-'))
            ->line('Staff: '.($this->booking->staff?->full_name ?? '-'))
            ->line('Date: '.(string) $this->booking->getAttribute('date'))
            ->line('Time: '.substr((string) $this->booking->time, 0, 5))
            ->line('Status: '.ucfirst((string) $this->booking->status))
            ->action('View Booking', route('bookings.show', $this->booking));
    }
}
