<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Notifications\Concerns\FormatsBookingAppointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCreatedAdminNotification extends Notification
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
        $this->booking->loadMissing(['service', 'staff', 'user']);

        $starts = $this->bookingAppointmentLabel($this->booking);

        return (new MailMessage)
            ->subject(__('[:app] New booking #:id', ['app' => config('app.name'), 'id' => $this->booking->id]))
            ->line(__('A new booking has been placed.'))
            ->line(__('Booking #:id', ['id' => $this->booking->id]))
            ->line(__('Customer: :name (:email)', [
                'name' => $this->booking->user?->name ?? '—',
                'email' => $this->booking->user?->email ?? '—',
            ]))
            ->line(__('Service: :name', ['name' => $this->booking->service?->name ?? '—']))
            ->line(__('Staff: :name', ['name' => $this->booking->staff?->full_name ?? '—']))
            ->line(__('When: :when', ['when' => $starts]))
            ->line(__('Status: :status', ['status' => __(ucfirst((string) $this->booking->status))]))
            ->action(__('View booking'), route('bookings.show', $this->booking));
    }
}
