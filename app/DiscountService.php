<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountService extends Model
{
    protected $table = 'discount_service';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
    	'discountId',
    	'serviceId',
    ];

    public function service(){
        return $this->belongsTo('App\Service','serviceId')->where('isActive',1);
    }

    public function discount(){
        return $this->belongsTo('App\Discount','discountId')->where('isActive',1);
    }
}
