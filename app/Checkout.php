<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    /**
     * The table associated with the model.
     * Overrides laravel table naming convention of snake case(plural)
     * Add a custom name for your table
     *
     * @var string
     */
    protected $table = 'checkout';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;    
}
