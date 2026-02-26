<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $fillable = [
        'name','description','status','cancelled_at'
    ];

    public function memberships(){
        return $this->hasMany(Membership::class);
    }

    public function members(){
        return $this->belongstoMany(User::class,'memberships')->withPivot('role','joined_at','left_at')->withTimestamps();
    }



    //tous les expenses dans une colocation
    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    //kola collocation 3ndha categories dialha
    public function categories(){
        return $this->hasMany(Categorie::class);
    }


    public function invitations(){
        return $this->hasMany(Invitation::class);
    }


}
