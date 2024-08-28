<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ModularCouchPart extends Model
{
    use HasFactory;

    public function couch(): BelongsTo
    {
        return $this->belongsTo(ModularCouch::class, 'couch_id');
    }

    public function samples(): BelongsToMany
    {
        return $this->belongsToMany(ModularCouchSample::class, 'modular_couch_part_sample', 'part_id', 'sample_id')
            ->withPivot(['count']);
    }
}
