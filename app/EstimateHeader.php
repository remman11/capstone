<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstimateHeader extends Model
{
    protected $table = 'estimate_header';
    protected $fillable = [
    	'customerId',
        'vehicleId',
    	'isFinalize',
    ];

    public function product(){
        return $this->hasMany('App\EstimateProduct','estimateId')->where('isActive',1);
    }

    public function customer(){
        return $this->belongsTo('App\Customer','customerId');
    }
    
    public function vehicle(){
        return $this->belongsTo('App\Vehicle','vehicleId');
    }
}