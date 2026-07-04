<?php

namespace App\Notifications;

use App\Models\Visitor;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewVisitorNotification extends Notification
{
    use Queueable;

    public function __construct(public Visitor $visitor) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('📢 New Visitor on Latocross Website')
            ->greeting('Hello!')
            ->line('Someone just visited your site:')
            ->line('🌐 Page: ' . $this->visitor->page_url)
            ->line('📍 Location: ' . ($this->visitor->country ?? 'Unknown') . ', ' . ($this->visitor->city ?? 'Unknown'))
            ->line('💻 Device: ' . $this->visitor->device . ' / ' . $this->visitor->browser)
            ->line('🕒 Time: ' . $this->visitor->created_at->format('D, d M Y H:i'))
            ->action('View All Visitors', url('/admin/visitors'));
    }
}