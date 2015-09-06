<?php

namespace PCI\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['desc'];
}
