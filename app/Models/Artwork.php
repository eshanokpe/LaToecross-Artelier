<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Artwork extends Model
{
    use HasFactory; 

    // CRITICAL: Allow ALL fields to be saved
    protected $fillable = [
        'title',
        'style',
        'description',
        'medium',
        'dimensions',
        'price',
        'is_for_sale',
        'is_featured',
        'image',
    ];

    protected $casts = [
        'is_for_sale' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
    ];

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => asset('storage/' . $this->image)
        );
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    // Automatically delete image when record is deleted
    protected static function booted()
    {
        static::deleting(function ($artwork) {
            if ($artwork->image && Storage::disk('public')->exists($artwork->image)) {
                Storage::disk('public')->delete($artwork->image);
            }
        });

        // Optional: Delete old image when updating
        static::updating(function ($artwork) {
            if ($artwork->isDirty('image') && $artwork->getOriginal('image')) {
                $oldImage = $artwork->getOriginal('image');
                if (Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
        });
    }
}