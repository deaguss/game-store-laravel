<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Library extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "library_games";

    protected $fillable = [
        'id',
        'game_id',
        'user_id',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'id' => 'string',
    ];
}
