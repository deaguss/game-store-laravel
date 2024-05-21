<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'description',
        'user_id',
        'created_at',
        'updated_at',
    ];

    protected $dates = ['deleted_at'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function games()
    {
        return $this->hasMany(Games::class, 'category_id', 'id');
    }

    protected $casts = [
        'id' => 'string',
    ];
}
