<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{

protected $fillable=[
    'user_id','coloc'
]
    

    //colocation
    public function colocation(){
        return $this->belongsTo(Colocation::class,'invited_by');
    }
    public function Inviter(){
        return $this->belongsTo()
    }
}
