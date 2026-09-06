<?php

namespace App\Models\User\Address\ValueObjects\PhoneNumber;

class PhoneNumber
{
    private string $number;

    private ?string $countryCode;

    public function __construct(string $number, ?string $countryCode = null)
    {
        $this->countryCode = $countryCode ? trim($countryCode) : null;
        $this->number = $this->normalize($number);
    }

    private function normalize(string $number): string
    {
        $number = trim($number);
        if ($this->countryCode !== null && $this->countryCode !== '' && str_starts_with($number, $this->countryCode)) {
            return substr($number, strlen($this->countryCode));
        }

        return $number;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }
}
