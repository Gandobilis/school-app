<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['title', 'short_description', 'detailed_description'];

    protected $fillable = ['image', 'syllabus', 'duration', 'fee', 'old_fee', 'start_date'];

    public function lecturers(): belongsToMany
    {
        return $this->belongsToMany(Course::class, 'lecturer_course', 'course_id', 'lecturer_id');
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $image) => url('/') . '/storage/' . $image
        );
    }

    protected function syllabus(): Attribute
    {
        return Attribute::make(
            get: fn(string $syllabus) => url('/') . '/storage/' . $syllabus
        );
    }
}
