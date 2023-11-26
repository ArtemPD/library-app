<?php

namespace App\Contracts\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

trait HasPhone
{

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->getAttribute('phone');
    }


    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            $parsedNumber = $phoneUtil->parse($this->phone, null);
            return $phoneUtil->getRegionCodeForNumber($parsedNumber);
        } catch (NumberParseException $e) {
            return null;
        }
    }


    /**
     * @return string|null
     */
    public function getCountryPhoneCode(): ?string
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            $parsedNumber = $phoneUtil->parse($this->phone, null);
            return $parsedNumber->getCountryCode();
        } catch (NumberParseException $e) {
            return null;
        }
    }


    /**
     * @return Attribute|null
     */
    protected function phoneTitle(): ?Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->phone ? [
                'code' => '+' . ltrim($this->getCountryPhoneCode(), '+'),
                'number' => PhoneNumberUtil::getInstance()->parse($this->phone)->getNationalNumber(),
                'value' => $this->phone,
            ] : null
        );
    }
}

