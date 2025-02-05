<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'Customer Name',
        'Phone Number',
        'Email',
        'Date of Birth',
        'Occupation',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            // Generate customer_id in "SKC-00001" format
            $latestCustomer = Customer::latest('id')->first();
            $nextId = $latestCustomer ? $latestCustomer->id + 1 : 1;
            $customer->customer_id = 'SKC-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);
        });
    }
}
