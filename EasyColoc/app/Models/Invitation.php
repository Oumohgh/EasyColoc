<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $casts=[
        'expires_at'=>'datetime',
    ];

    //colocation
    public function colocation(){
        return $this->belongsTo(Colocation::class,'invited_by');
    }
    public function Inviter(){
        return $this->belongsTo()
    }
}
