<?php

namespace App\Traits;

use EntityManager;
use Illuminate\Support\Collection;

trait EntityReturnsAll
{
    /**
     * Returns all records of the entity in a collections of objects
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all()
    {
        $query = EntityManager::createQuery("Select record from " . __CLASS__ . " record");
        return new Collection($query->getResult());
    }
}
