<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['title', 'text', 'description'];

    protected $fillable = ['image'];

    public function lecturers(): belongsToMany
    {
        return $this->belongsToMany(Course::class, 'lecturer_course');
    }
}
