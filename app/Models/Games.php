<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Games extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'category_id',
        'title',
        'imageUrl',
        'release_date',
        'description',
        'developer',
        'price',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['deleted_at'];
    protected $primaryKey = 'id';
    public $incrementing = false;

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    protected $casts = [
        'id' => 'string',
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'detail_user_games', 'game_id', 'user_id');
    }

    public function games()
    {
        return $this->belongsToMany(Games::class, 'library_games', 'user_id', 'game_id');
    }
}
