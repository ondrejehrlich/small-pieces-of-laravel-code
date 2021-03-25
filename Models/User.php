<?php

namespace App\Models;

use App\Traits\Likes;
use App\Models\Answer;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Likes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The comments that belong to user.
     *
     * @return HasMany
    */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The articles that belong to user.
     *
     * @return HasMany
    */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * User can have many answers.
     *
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
