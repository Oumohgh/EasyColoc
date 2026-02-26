<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
                'title', 'amount', 'date','user_id', 'colocation_id','category_id'
    ];

    public function payer(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function colocation(){
        return $this->belongsTo(Colocation::class);
    }

    public function category(){
        return $this->belongsTo(Categorie::class);

    }

    public function shares(){
        return $this->hasMany(ExpenseShare::class);
    }
}
