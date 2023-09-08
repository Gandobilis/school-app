<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lecturer extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['first_name', 'last_name', 'position', 'description'];

    protected $fillable = ['image', 'linkedin'];

    public function courses(): belongsToMany
    {
        return $this->belongsToMany(Course::class, 'lecturer_course');
    }
}
