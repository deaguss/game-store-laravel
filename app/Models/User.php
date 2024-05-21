<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'image_url',
        'email',
        'password',
        'address',
        'phone',
        'created_at',
        'updated_at'
    ];

    protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'id' => 'string',
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];


    public function games()
    {
        return $this->belongsToMany(Games::class, 'detail_user_games', 'user_id', 'game_id');
    }

    public function categories(){
        return $this->hasMany(Category::class, 'user_id', 'id');
    }

    public function billboards(){
        return $this->hasMany(Billboard::class, 'user_id', 'id');
    }

    public function libraries()
    {
        return $this->belongsToMany(Games::class, 'library_games', 'user_id', 'game_id')
            ->withTimestamps();
    }

    public function cart()
    {
        return $this->belongsToMany(Games::class, 'detail_cart_games', 'user_id', 'game_id')
            ->withTimestamps();
    }

    public function activeOTP()
    {
        return $this->hasOne(UserOTP::class,'user_id')->where('expired_at','>', 'now()');
    }
}
