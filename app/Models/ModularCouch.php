<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModularCouch extends Model
{
    use HasFactory;
    
    public function parts(): HasMany
    {
        return $this->hasMany(ModularCouchPart::class, 'couch_id');
    }

    public function samples(): HasMany
    {
        return $this->hasMany(ModularCouchSample::class, 'couch_id');
    }

    protected function priceMin1(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->parts()->min('price')
        );
    }

    protected function priceMin2(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->parts->min('price')
        );
    }
}
