<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $image) => url('/') . '/storage/' . $image
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn(string $createAt) => Carbon::parse($createAt)->format('d-m-Y H:i:s')
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn(string $updatedAt) => Carbon::parse($updatedAt)->format('d-m-Y H:i:s')
        );
    }
}
