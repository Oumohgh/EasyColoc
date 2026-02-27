<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payement extends Model
{
     protected $fillable = ['amount', 'paid_at', 'user_id', 'expense_id'];


      public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }


}
