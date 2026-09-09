<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'Description',
        'Thumbnail',
        'order',
        'is_published',
        'file_path',
        'video_url',
        'content',
    ];

    public function getDescriptionAttribute()
    {
        return $this->attributes['Description'] ?? null;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['Description'] = $value;
    }

    public function getThumbnailAttribute()
    {
        return $this->attributes['Thumbnail'] ?? null;
    }

    public function setThumbnailAttribute($value)
    {
        $this->attributes['Thumbnail'] = $value;
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function progress()
    {
        return $this->hasMany(ModuleProgress::class);
    }
}