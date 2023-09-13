<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * @method static create(mixed $validated)
 */
class Banner extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public array $translatedAttributes = ['title', 'description'];
    protected $fillable = ['image', 'link'];
}
