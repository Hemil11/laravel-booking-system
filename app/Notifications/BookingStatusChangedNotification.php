<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusChangedNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected Booking $booking,
        protected string $fromStatus,
        protected string $toStatus
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $this->booking->loadMissing(['service', 'staff']);

        return (new MailMessage)
            ->subject('Booking Status Updated #'.$this->booking->id)
            ->greeting('Hello '.$notifiable->name.',')
            ->line('Your booking status has changed.')
            ->line('Booking ID: '.$this->booking->id)
            ->line('Service: '.($this->booking->service?->name ?? '-'))
            ->line('Staff: '.($this->booking->staff?->full_name ?? '-'))
            ->line('From: '.ucfirst($this->fromStatus))
            ->line('To: '.ucfirst($this->toStatus))
            ->action('View Booking', route('bookings.show', $this->booking));
    }
}
