<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    //
    protected $table = 'call';

    protected $fillable = [
        'patient_id','patient_name','doctor_id','type','status', 'profession', 'opentok_session', 'opentok_token'
    ];

    public function doctor() {
        return $this->belongsTo("App\User", "doctor_id", "id");
    }

    public function specialtie() {
        return $this->belongsTo("App\User", "name", "id");
    }
}
