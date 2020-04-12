<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    protected $primaryKey = 'sku';

    protected $dates = ['created_at', 'updated_at'];

    public $incrementing = false;
    
    protected $fillable = [
        'sku', 'name', 'name_en', 'shortname', 'product_id', 'barcode', 'image', 'call_unit', 'full_price', 'price', 'cost', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at' 
    ];

    public function options()
    {
        return $this->belongsToMany('App\Option', 'option_sku', 'sku', 'option_id')->withTimestamps();
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

    public function stock()
    {
        return $this->hasOne('App\Stock', 'sku');
    }

    public function created_by_user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    public function updated_by_user()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }
}
