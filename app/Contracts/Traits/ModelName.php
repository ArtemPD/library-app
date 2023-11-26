<?php

namespace App\Contracts\Traits;

trait ModelName
{

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return get_class($this);
    }

    /**
     * @return string
     */
    public function getSessionName(): string
    {
        return get_class($this) . '::' . $this->getAuthIdentifier();
    }
}
