<?php

namespace App\Tenancy\Traits;

use App\Models\Parque;
use App\Tenancy\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToTenant
{
    /**
     * Inicializa a trait, registrando o escopo global e ouvintes de eventos.
     */
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function ($model) {
            if (app()->bound('tenant') && app('tenant')->check()) {
                if (empty($model->parque_id)) {
                    $model->parque_id = app('tenant')->id();
                }
            }
        });
    }

    /**
     * Relacionamento do modelo com o Parque (Tenant).
     */
    public function parque(): BelongsTo
    {
        return $this->belongsTo(Parque::class);
    }
}
