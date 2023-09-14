<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Banner extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['image', 'link'];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $path) => url('/') . '/storage/' . $path
        );
    }
}
