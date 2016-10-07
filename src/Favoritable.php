<?php

namespace Programmende\Favoritable;

trait Favoritable
{
    /**
     * Fetch all favorites for the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    /**
     * Scope a query to records favorited by the given user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  User                                  $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFavoritedBy($query, User $user)
    {
        return $query->whereHas('favorites', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    /**
     * Determine if the model is favorited by the given user.
     *
     * @param  User $user
     * @return boolean
     */
    public function isFavoritedBy()
    {
        if (auth()->check()) {
            return $this->favorites()
                ->where('user_id', auth()->user()->id)
                ->exists();
        }
        return false;

    }

    /**
     * Have the authenticated user favorite the model.
     *
     * @return boolean
     */
    public function favorite()
    {

        if (auth()->check()) {
            $user = auth()->user();
            if ($this->favorites()
                ->where('user_id', $user->id)
                ->exists()) {
                $this->favorites()->where('user_id', '=', $user->id)->where('favoritable_id', '=', $this->id)->delete();
                return false;
            } else {
                $fav = new Favorite();
                $fav->user_id = $user->id;
                $this->favorites()->save($fav);
                return true;
            }
            return false;

        }

    }

    /**
     * Returns the favorite count
     *
     * @return integer
     */
    public function favoritesCount()
    {
        return $this->favorites()->count();
    }
}
