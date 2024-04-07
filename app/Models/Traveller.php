<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traveller extends Model
{

    protected $fillable = [
        'reservation_opera_id'
    ];

    public function getFullNameAttribute(){
        return "{$this->first_name} {$this->last_name}";
    }


    public function reservations(){
        return $this->belongsToMany( Reservation::class)->withPivot(['lead','comment']);
    }


}
