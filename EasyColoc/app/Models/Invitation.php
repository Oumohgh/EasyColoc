<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{

protected $fillable=[
   'colocation_id', 'invited_by', 'invited_user_id','email', 'token', 'status', 'expires_at'
    ];


    //colocation
    public function colocation(){
        return $this->belongsTo(Colocation::class);
    }
    public function Inviter(){
        return $this->belongsTo(User::class);
    }
}
