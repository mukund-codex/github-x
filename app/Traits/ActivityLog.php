<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ActivityLog
{

    public function activity(
        string $log,
        Model|int|string|null $causer = null,
        Model|int|string|null $subject = null,
        array|Collection $properties = []
    ): void {
        activity()
            ->causedBy($causer)
            ->performedOn($subject)
            ->withProperties($properties)
            ->log($log);
    }

}
