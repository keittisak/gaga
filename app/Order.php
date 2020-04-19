<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'id', 'code', 'customer_id', 'total_quantity', 'total_amount', 'discount_amount', 'shipping_fee', 'overpay', 'net_total_amount', 'shipping_full_name', 'shipping_full_address', 'shipping_subdistrict_id', 'shipping_phone', 'status', 'sale_channel', 'tracking_code', 'payment_method_id', 'shipment_method_id', 'remark', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    public function details()
    {
        return $this->hasMany('App\OrderDetail');
    }

    public function customer()
    {
        return $this->belongsTo('App\User', 'customer_id');
    }

    public function payments()
    {
        return $this->belongsToMany('App\Payment')->withPivot('amount_by_order')->withTimestamps();
    }

    public function created_by_user()
    {
        return $this->belongsTo('App\User', 'created_by')->withTrashed();
    }

    public function updated_by_user()
    {
        return $this->belongsTo('App\User', 'updated_by')->withTrashed();
    }
}