<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mattress extends Model
{
    use HasFactory;

    public function samples(): HasMany
    {
        return $this->hasMany(MattressSample::class);
    }

    protected function priceMax1(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->samples()->max('price'),
        );
    }

    protected function priceMin1(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->samples()->min('price'),
        );
    }

    protected function priceMax2(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->samples->max('price'),
        );
    }

    protected function priceMin2(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->samples->min('price'),
        );
    }
}
