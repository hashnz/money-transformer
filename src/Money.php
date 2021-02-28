<?php

declare(strict_types=1);

namespace App;

class Money
{
    private int $dollars;
    private int $cents;

    /**
     * This is a hack of a money class, just to provide some validation and avoid floats
     */
    public function __construct(int $dollars, int $cents)
    {
        $this->dollars = $dollars;
        $this->cents = $cents;
    }

    public static function fromNumber($amount): self
    {
        if (!is_numeric($amount)) {
            throw new \InvalidArgumentException('Invalid money value: ' . $amount);
        }
        $number = round((float) $amount, 2);
        $number *= 100;

        return new self(intdiv((int) $number, 100), $number % 100);
    }

    public function getCents(): int
    {
        return $this->cents;
    }

    public function getDollars(): int
    {
        return $this->dollars;
    }
}
