<?php

namespace App\Tenancy;

use App\Models\Parque;

class TenantManager
{
    protected ?Parque $tenant = null;

    /**
     * Define o parque ativo para a requisição atual.
     */
    public function set(?Parque $tenant): void
    {
        $this->tenant = $tenant;
    }

    /**
     * Recupera o parque ativo.
     */
    public function get(): ?Parque
    {
        return $this->tenant;
    }

    /**
     * Recupera o ID do parque ativo.
     */
    public function id(): ?int
    {
        return $this->tenant?->id;
    }

    /**
     * Verifica se existe um parque ativo na requisição.
     */
    public function check(): bool
    {
        return !is_null($this->tenant);
    }
}
