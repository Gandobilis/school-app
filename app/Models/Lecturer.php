<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lecturer extends Model
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['name', 'position', 'description'];

    protected $fillable = [
        'image',
        'linkedin'
    ];

    public function courses(): belongsToMany
    {
        return $this->belongsToMany(Course::class, 'lecturer_course');
    }
}
