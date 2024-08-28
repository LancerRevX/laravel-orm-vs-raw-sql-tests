<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModularCouchSample extends Model
{
    use HasFactory;

    public function couch(): BelongsTo
    {
        return $this->belongsTo(ModularCouch::class, 'couch_id');
    }

    public function parts(): BelongsToMany
    {
        return $this->belongsToMany(ModularCouchPart::class, 'modular_couch_part_sample', 'sample_id', 'part_id')
            ->withPivot(['count']);
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: function() {
                return $this->parts->reduce(fn ($sum, $part) => $sum + $part->price * $part->pivot['count']);
            }
        );
    }
}
