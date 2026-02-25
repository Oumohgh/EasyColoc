<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [

        'name', 'email', 'password',
        'is_admin', 'is_banned', 'reputation'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
 protected $casts = [
        'is_admin'  => 'boolean',
        'is_banned' => 'boolean',
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

//user wahed --bzzaf memberships
public function memberships() {
        return $this->hasMany(Membership::class);
    }
    //user 1 ---- bzaf collocations(b membership)
    public function colocations(){
        return $this->BelongsToMany(Colocation::class,'memberships')->withPivot('role','joined_at','left_at')->withTimestamps();
    }
    //user wahed --- exp(taykhless)
    public function expenses(){
        return $this->hasMany(Expense::class);
    }

    //user wahed --bzaf dial expenseshare(li tay tssal)
    public function expenseShares(){
        return $this->hasMany(ExpenseShare::class);
    }
    //user wahed --- bzaf invitations(li seft)
    public function sentInvitations(){
        return $this->hasMany(Invitation::class,'invited_by');
    }

    public function receivedInvitations(){
        return $this->hasMnay(Invitation::class,'invited_user_id');
    }
}
