<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    use HasFactory ,Searchable;
    use SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.name' => 10,
            'products.details' => 5,
            'products.description' => 2,
        ],

    ];
    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $extraFields = [
            'categories' =>$this->categories()->pluck('name')->toArray(),
        ];

        return array_merge($array,$extraFields);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function scopeMightAlsoLike($query)
    {
        return $query->inRandomOrder()->take(4);
    }

}
