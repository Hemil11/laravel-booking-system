<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Notifications\Concerns\FormatsBookingAppointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusChangedNotification extends Notification
{
    use FormatsBookingAppointment;
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

        $when = $this->bookingAppointmentLabel($this->booking);

        return (new MailMessage)
            ->subject(__('[:app] Booking #:id status update', ['app' => config('app.name'), 'id' => $this->booking->id]))
            ->greeting(__('Hello :name,', ['name' => $notifiable->name]))
            ->line(__('Your booking status has been updated.'))
            ->line(__('Service: :name', ['name' => $this->booking->service?->name ?? '—']))
            ->line(__('Staff: :name', ['name' => $this->booking->staff?->full_name ?? '—']))
            ->line(__('Appointment: :when', ['when' => $when]))
            ->line(__('Previous status: :status', ['status' => __(ucfirst($this->fromStatus))]))
            ->line(__('New status: :status', ['status' => __(ucfirst($this->toStatus))]))
            ->action(__('View booking'), route('bookings.show', $this->booking));
    }
}
