<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Model;

class MovementType extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['desc'];
}
