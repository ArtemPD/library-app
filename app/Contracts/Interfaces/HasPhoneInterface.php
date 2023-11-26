<?php


namespace App\Contracts\Interfaces;

interface HasPhoneInterface
{
    /**
     * @return string|null
     */
    public function getPhone(): ?string;


    /**
     * @return string|null
     */
    public function getCountryCode(): ?string;


    /**
     * @return string|null
     */
    public function getCountryPhoneCode(): ?string;
}

