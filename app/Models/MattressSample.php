<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MattressSample extends Model
{
    use HasFactory;

    public function mattress(): BelongsTo
    {
        return $this->belongsTo(Mattress::class);
    }
}
