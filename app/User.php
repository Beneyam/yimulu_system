<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone_number', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function children(){
        return $this->hasMany( 'App\User', 'parent_id', 'id' );
    }
      
    public function parent(){
        return $this->hasOne( 'App\User', 'id', 'parent_id' );
    }
    public function hasAnyRoles($roles){
        if($this->roles()->whereIn('name',$roles)->first()){
            return true;
        }
        return false;
    }
    public function hasRole($role){
        if($this->roles()->where('name',$role)->first()){  //whereIn for array and 
            return true;
        }
        return false;
    }

    public function balances(){
        return $this->hasMany(Balance::class);
    }
    
    
    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
    public function debts(){
        return $this->hasMany(Debt::class);
    }
    public function deposits(){
        return $this->hasMany(Deposit::class);
    }
    public function requests(){
        return $this->hasMany(Deposit::class);
    }
    public function activations(){
        return $this->hasMany(Deposit::class);
    }
    public function yimulu_sales(){
        return $this->hasMany(Yimulu_sale::class);
    }
}
