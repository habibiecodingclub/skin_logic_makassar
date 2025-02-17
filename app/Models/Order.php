<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        // 'order_id',
        'customer_id',
        'product_name',
        'quantity',
        'total_price',
        'order_date',
    ];

       protected static function boot()
    {
        parent::boot();

        // Gunakan function generateOrderId saat membuat data baru
        static::creating(function ($model) {
            $model->order_id = self::generateOrderId();
        });
    }
     /**
     * Generate a unique order ID.
     *
     * @return string
     */
    public static function generateOrderId()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; // Karakter yang diizinkan
        $randomString = '';

        // Generate 8 karakter random
        for ($i = 0; $i < 8; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        $orderId = 'SKO-' . $randomString; // Format: SKO-8DIGITRANDOM

        // Pastikan order_id unik
        while (Order::where('order_id', $orderId)->exists()) {
            $randomString = '';
            for ($i = 0; $i < 8; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            $orderId = 'SKO-' . $randomString;
        }

        return $orderId;
    }


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
