<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parque extends Model
{
    use HasFactory;

    protected $table = 'parques';

    protected $fillable = [
        'nome',
        'slug',
        'custom_domain',
        'gateway_recipient_id',
        'status',
        'portal_enabled',
        'expires_at',
        'comissao_percentual',
        'comissao_fixa',
    ];

    protected $casts = [
        'expires_at' => 'date',
        'comissao_percentual' => 'float',
        'comissao_fixa' => 'float',
        'portal_enabled' => 'boolean',
    ];

    /**
     * Verifica se o parque está ativo.
     */
    public function isActive(): bool
    {
        return $this->status === 'ativo';
    }

    /**
     * Verifica se a licença do parque expirou.
     */
    public function isExpired(): bool
    {
        if (is_null($this->expires_at)) {
            return false;
        }

        return now()->startOfDay()->greaterThan($this->expires_at->startOfDay());
    }
}
