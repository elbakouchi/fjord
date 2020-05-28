<?php

namespace Fjord\Crud\Fields\Relations;

use Fjord\Crud\ManyRelationField;

class HasMany extends ManyRelationField
{
    use Concerns\ManagesRelation;

    /**
     * Properties passed to Vue component.
     *
     * @var array
     */
    protected $props = [
        'type' => 'hasMany'
    ];

    /**
     * Required attributes.
     *
     * @var array
     */
    protected $required = [
        'title',
        'model',
        'preview'
    ];

    /**
     * Available Field attributes.
     *
     * @var array
     */
    protected $available = [
        'title',
        'model',
        'form',
        'hint',
        'query',
        'preview',
        'confirm',
        'sortable',
        'filter',
        'relatedCols',
        'small',
        'perPage',
        'searchable',
        'tags',
        'tagVariant',
        'showTableHead'
    ];

    /**
     * Default Field attributes.
     *
     * @var array
     */
    protected $defaults = [
        'confirm' => false,
        'sortable' => false,
        'relatedCols' => 12,
        'small' => false,
        'perPage' => 10,
        'searchable' => false,
        'tags' => false,
        'tagVariant' => 'secondary',
    ];

    /**
     * Set relation attributes.
     *
     * @param string $model
     * @return self
     */
    protected function setRelationAttributes($relation)
    {
        $this->attributes['foreign_key'] = $relation->getForeignKeyName();
    }
}
