<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'total_cents',
        'status',
        'payment_status',
        'payment_gateway',
        'payment_reference',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalAttribute(): float
    {
        return $this->total_cents / 100;
    }

    /**
     * Best-effort WhatsApp deep link from the stored phone number.
     * Assumes Nigerian numbers when a local "0..." format is used.
     */
    public function getWhatsappUrlAttribute(): ?string
    {
        if (! $this->customer_phone) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $this->customer_phone);

        if (str_starts_with($digits, '0')) {
            $digits = '234'.substr($digits, 1);
        }

        return "https://wa.me/{$digits}";
    }
}
