<?php

namespace App\Support;

use Spatie\Permission\Contracts\PermissionsTeamResolver;

class FilamentTeamResolver implements PermissionsTeamResolver
{
    protected int|string|null $teamId = null;

    public function setPermissionsTeamId($teamId): void
    {
        $this->teamId = $teamId;
    }

    public function getPermissionsTeamId(): int|string|null
    {
        // Priorité au tenant Filament
        if (filament()->getTenant()) {
            return filament()->getTenant()->id;
        }

        // fallback éventuel
        return $this->teamId;
    }
}