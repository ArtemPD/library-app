<?php

namespace App\Contracts\Interfaces;


interface UserInterface
{
    /**
     * @return bool
     */
    public function isPublisher(): bool;
}
