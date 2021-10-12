<?php

namespace App\Models;

use App\Traits\SelfReferenceTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, SelfReferenceTrait;

    protected $fillable = ['name', 'slug', 'image', 'parent_id'];
}
