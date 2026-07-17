<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public array $statusCopy = [
        'processing' => [
            'headline' => 'Your order is being prepared',
            'body' => 'We\'ve started preparing your fragrance for dispatch. We\'ll let you know the moment it ships.',
        ],
        'shipped' => [
            'headline' => 'Your order is on its way',
            'body' => 'Your order has shipped and is on its way to you.',
        ],
        'delivered' => [
            'headline' => 'Your order has been delivered',
            'body' => 'Your order has been marked as delivered. We hope you love it.',
        ],
        'cancelled' => [
            'headline' => 'Your order has been cancelled',
            'body' => 'Your order has been cancelled. If this wasn\'t expected, please get in touch.',
        ],
        'pending' => [
            'headline' => 'Your order status has been updated',
            'body' => 'Your order is now pending review.',
        ],
    ];

    public function __construct(public Order $order)
    {
        $this->order->loadMissing('items');
    }

    public function envelope(): Envelope
    {
        $headline = $this->statusCopy[$this->order->status]['headline'] ?? 'Your order status has been updated';

        return new Envelope(
            subject: $headline.' — Order #'.$this->order->id,
        );
    }

    public function content(): Content
    {
        $copy = $this->statusCopy[$this->order->status] ?? $this->statusCopy['pending'];

        return new Content(
            view: 'emails.order-status-updated',
            with: [
                'headline' => $copy['headline'],
                'body' => $copy['body'],
            ],
        );
    }
}
