<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Tenancy\Traits\BelongsToTenant;

class Corrida extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'senha_id',
        'numero_corrida',
        'resultado',
        'parque_id',
    ];

    public function senha(): BelongsTo
    {
        return $this->belongsTo(Senha::class);
    }
}
