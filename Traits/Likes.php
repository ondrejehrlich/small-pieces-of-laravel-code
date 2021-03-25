<?php

namespace App\Traits;

use App\Models\Like;
use App\Interfaces\Likeable;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Likes
{
    /**
     * Return likes of resource.
     *
     * @return HasMany
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Add like.
     *
     * @param Likeable $likeable
     * @return self
     */
    public function addLike(Likeable $likeable): self
    {
        if ($this->hasLiked($likeable)) {
            return $this;
        }

        (new Like)
            ->user()->associate($this)
            ->likeable()->associate($likeable)
            ->save();

        return $this;
    }

    /**
     * Remove like.
     *
     * @param Likeable $likeable
     * @return self
     */
    public function removeLike(Likeable $likeable): self
    {
        if (!$this->hasLiked($likeable)) {
            return $this;
        }

        $likeable->likes()->whereHas('user', function ($q) {
            $q->whereId($this->id);
        })->delete();

        return $this;
    }

    /**
     * Check if the Likeable aleready has a like.
     *
     * @param Likeable $likeable
     * @return boolean
     */
    public function hasLiked(Likeable $likeable): bool
    {
        if (!$likeable->exists) {
            return false;
        }

        return $likeable->likes()->whereHas('user', function ($q) {
            $q->whereId($this->id);
        })->exists();
    }
}
