<?php

namespace App\Tenancy\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    /**
     * Aplica o filtro de tenant à query.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (app()->bound('tenant') && app('tenant')->check()) {
            $builder->where($model->getTable() . '.parque_id', app('tenant')->id());
        }
    }
}
