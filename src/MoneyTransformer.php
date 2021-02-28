<?php

namespace App;

class MoneyTransformer
{
    private const numbers = [
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen',
        20 => 'twenty',
        30 => 'thirty',
        40 => 'forty',
        50 => 'fifty',
        60 => 'sixty',
        70 => 'seventy',
        80 => 'eighty',
        90 => 'ninety',
    ];

    public static function transform(Money $money): string
    {
        // only handles 6 digits
        if ($money->getDollars() > 999999) {
            throw new \RuntimeException('Cannot transform large values: ' . $money->getDollars());
        }

        // edge case, just hard code it
        if (!$money->getDollars() && !$money->getCents()) {
            return 'zero dollars';
        }

        // TODO should be made recursive to handle larger numbers
        $dollarValue = $money->getDollars();
        $thousands = self::dddToWords(intdiv($dollarValue, 1000));
        $dollarValue %= 1000;
        $hundreds = self::dddToWords($dollarValue);
        $text = '';
        $text .= $thousands ? $thousands . ' thousand' : '';
        $text .= $hundreds ? ' ' . $hundreds : '';
        if ($text) {
            $text .= $money->getDollars() === 1 ? ' dollar' : ' dollars';
        }

        $cents = self::dddToWords($money->getCents());
        if ($cents) {
            if ($text) {
                $text .= ' and ';
            }
            $text .= $cents;
            $text .= $money->getCents() === 1 ? ' cent' : ' cents';
        }

        return trim($text);
    }

    /**
     * Convert up to 3 digit number to words
     */
    private static function dddToWords(int $ddd): string
    {
        if ($ddd > 999) {
            throw new \InvalidArgumentException('Number must be less than 1000: ' . $ddd);
        }

        $hundreds = intdiv($ddd, 100);
        $remainder = $ddd % 100;

        $hundredsText = $hundreds ? self::numbers[$hundreds] . ' hundred' : '';
        if ($remainder === 0) {
            $tensText = '';
        } elseif ($remainder < 20) {
            $tensText = self::numbers[$remainder];
        } else {
            $ones = $remainder % 10;
            $tens = $remainder - $ones;
            $tensText = self::numbers[$tens];
            if ($ones) {
                $tensText .= ' ' . self::numbers[$ones];
            }
        }
        $join = ($hundredsText && $tensText) ? ' and ' : '';

        return $hundredsText . $join . $tensText;
    }
}
