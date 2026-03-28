<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Notifications\Concerns\FormatsBookingAppointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCreatedNotification extends Notification
{
    use FormatsBookingAppointment;
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

        $when = $this->bookingAppointmentLabel($this->booking);

        return (new MailMessage)
            ->subject(__('[:app] Booking confirmed — #:id', ['app' => config('app.name'), 'id' => $this->booking->id]))
            ->greeting(__('Hello :name,', ['name' => $notifiable->name]))
            ->line(__('Your booking has been recorded successfully.'))
            ->line(__('Service: :name', ['name' => $this->booking->service?->name ?? '—']))
            ->line(__('Staff: :name', ['name' => $this->booking->staff?->full_name ?? '—']))
            ->line(__('Appointment: :when', ['when' => $when]))
            ->line(__('Status: :status', ['status' => __(ucfirst((string) $this->booking->status))]))
            ->action(__('View booking'), route('bookings.show', $this->booking));
    }
}
