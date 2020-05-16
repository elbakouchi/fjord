<?php

namespace Fjord\Support\Macros;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class WhereLike
{
    /**
     * Create new WhereLike instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $self = $this;

        Builder::macro('whereLike', function ($attributes, string $searchTerm) use ($self) {
            return $self->whereLike($this, $attributes, $searchTerm);
        });
    }

    /**
     * whereLike macro for query builder.
     *
     * @return void
     */
    public function whereLike(Builder $query, $attributes, string $searchTerm)
    {
        return $query->where(function (Builder $query) use ($attributes, $searchTerm) {
            foreach (Arr::wrap($attributes) as $attribute) {
                $query->when(
                    Str::contains($attribute, '.'),
                    function (Builder $query) use ($attribute, $searchTerm) {
                        [$relationName, $relationAttribute] = explode('.', $attribute);
                        $this->whereRelatedAttributeLike(
                            $query,
                            $relationName,
                            $relationAttribute,
                            $searchTerm
                        );
                    },
                    function (Builder $query) use ($attribute, $searchTerm) {
                        $this->whereAttributeLike(
                            $query,
                            $attribute,
                            $searchTerm
                        );
                    }
                );
            }
        });
    }

    /**
     * Where related attribute like
     *
     * @param Builder $query
     * @param string $relationName
     * @param string $attribute
     * @param mixed $searchTerm
     * @return void
     */
    public function whereRelatedAttributeLike($query, $relationName, $attribute, $searchTerm)
    {
        return $query->orWhereHas($relationName, function (Builder $query) use ($attribute, $searchTerm) {
            $this->whereAttributeLike(
                $query,
                $attribute,
                $searchTerm,
                $or = false
            );
        });
    }

    /**
     * Where attribute like.
     *
     * @param Builder $query
     * @param string $attribute
     * @param mixed $searchTerm
     * @param boolean $or
     * @return void
     */
    public function whereAttributeLike($query, $attribute, $searchTerm, $or = true)
    {
        if (is_translatable($query->getModel())) {
            if ($or) {
                $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
            } else {
                $query->where($attribute, 'LIKE', "%{$searchTerm}%");
            }
        } else {
            if ($or) {
                $query->orWhereTranslationLike($attribute, "%{$searchTerm}%");
            } else {
                $query->whereTranslationLike($attribute, "%{$searchTerm}%");
            }
        }
    }
}