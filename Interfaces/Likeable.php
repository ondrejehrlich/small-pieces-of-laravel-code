<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Likeable
{
    /**
     * Likeable model has to contain relationship with likes.
     *
     * @return MorphMany
     */
    public function likes(): MorphMany;
}
