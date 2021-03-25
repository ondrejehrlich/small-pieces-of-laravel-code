<?php

namespace App\Models;

use App\Interfaces\Likeable;
use App\Models\Tag;
use App\Models\User;
use App\Models\Comment;
use App\Traits;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model implements Likeable
{
    use HasFactory, Traits\Likeable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'user_id',
        'slug',
        'text',
        'teaser'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * An article can belong to one authon.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Article can belong to many tags.
     *
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Comments that belong to the article.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
    * Get the text of the article.
    * Remove htmlspecials and replace new lines with <p> elements
    *
    * @param  string  $text
    * @return string
    */
    public function getTextAttribute($text): string
    {
        $text  = htmlspecialchars($text);
        $text  = nl2br($text);
        $text  = str_replace("<br />", "</p>\n<p>", $text);
        $text  = "<p>" . $text . "</p>";
        $text  = str_replace("<p>\n</p>\n", "", $text);
        return $text;
    }

    /**
     * Collumns, that are searchable.
     *
     * @return array
     */
    public static function searchableColumns(): array
    {
        return ['title', 'text'];
    }
}
