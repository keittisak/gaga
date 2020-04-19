<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = [
        'sku' ,'quantity', 'type', 'reference_code', 'remark', 'created_by', 'updated_by'
    ];

    public function tenant(){
        return $this->belongsTo('App\Tenant');
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
