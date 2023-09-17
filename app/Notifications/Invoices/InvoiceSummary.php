<?php

namespace App\Notifications\Invoices;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceSummary extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private readonly Invoice $invoice
    ) {
        $this->invoice->load(['currency'])
            ->loadCount(['items']);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject("Invoice Summary {$this->invoice->reference}")
            ->greeting("Hello, {$notifiable->name}!")
            ->line("The invoice {$this->invoice->reference} was recorded successfully.")
            ->line("It was issued on {$this->invoice->issue_date} at {$this->invoice->issue_time}.")
            ->line("The total amount is {$this->invoice->total_amount} {$this->invoice->currency->code}.")
            ->line("And {$this->invoice->items_count} items were recorded.")
            ->line('Thank you for using our application!');
    }
}
