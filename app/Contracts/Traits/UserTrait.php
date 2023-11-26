<?php

namespace App\Contracts\Traits;


trait UserTrait
{
    /**
     * @return bool
     */
    public function isPublisher(): bool
    {
        return $this->getShortName() == "Publisher";
    }
}
