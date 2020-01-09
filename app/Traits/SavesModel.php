<?php

namespace App\Traits;

use Carbon\Carbon;
use EntityManager;

trait SavesModel
{

    public function save()
    {
        if (property_exists($this, 'created_at')) {
            $this->created_at = $this->created_at ?? Carbon::now();
        }
        if (property_exists($this, 'updated_at')) {
            $this->updated = Carbon::now();
        }
        EntityManager::persist($this);
        EntityManager::flush();
    }
}
