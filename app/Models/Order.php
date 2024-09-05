<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Order extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'tbl_order';
    protected $primaryKey = 'oid';
    protected $fillable = [
        'order_id',
        'cust_id',
        'razor_order_id',
        'product_count',
        'payment_amount', // TotalAmount
        'delivery_address', // TotalAmount
        'shipping_charge', // Shipping Charges
        'cgst',
        'sgst',
        'discount',
        'payment_type', // UPI,Card,COD
        'payment_status', // Paid,Unpaid
        'order_status', // Accepted,Intransit,OutForDelivery,Delivered,Cancel
        'remark', // addtional note,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'password' => 'hashed',
    // ];
}
