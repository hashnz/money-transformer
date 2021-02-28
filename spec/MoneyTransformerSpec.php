<?php

namespace spec\App;

use App\Money;
use App\MoneyTransformer;
use PhpSpec\ObjectBehavior;

class MoneyTransformerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MoneyTransformer::class);
    }

    // basic tests from spec
    function it_transforms_zero()
    {
        $this->transform(Money::fromNumber(0))->shouldBe('zero dollars');
        $this->transform(Money::fromNumber(0.0))->shouldBe('zero dollars');
        $this->transform(Money::fromNumber(0.00))->shouldBe('zero dollars');
    }

    function it_transforms_12_cents()
    {
        $this->transform(Money::fromNumber(0.12))->shouldBe('twelve cents');
    }

    function it_transforms_10_dollars_55_cents()
    {
        $this->transform(Money::fromNumber(10.55))->shouldBe('ten dollars and fifty five cents');
    }

    function it_transforms_120_dollars()
    {
        $this->transform(Money::fromNumber(120))->shouldBe('one hundred and twenty dollars');
        $this->transform(Money::fromNumber(120.0))->shouldBe('one hundred and twenty dollars');
        $this->transform(Money::fromNumber(120.00))->shouldBe('one hundred and twenty dollars');
    }

    function it_transforms_1000_dollars()
    {
        $this->transform(Money::fromNumber(1000))->shouldBe('one thousand dollars');
    }

    // additional tests
    function it_transforms_singular_cents()
    {
        $this->transform(Money::fromNumber(0.01))->shouldBe('one cent');
        $this->transform(Money::fromNumber(19.01))->shouldBe('nineteen dollars and one cent');
    }

    function it_transforms_singular_dollars()
    {
        $this->transform(Money::fromNumber(1))->shouldBe('one dollar');
        $this->transform(Money::fromNumber(1.01))->shouldBe('one dollar and one cent');
        $this->transform(Money::fromNumber(1.11))->shouldBe('one dollar and eleven cents');
    }

    function it_transforms_a_bunch_of_values()
    {
        $this->transform(Money::fromNumber(1100.00))->shouldBe('one thousand one hundred dollars');
        $this->transform(Money::fromNumber(99))->shouldBe('ninety nine dollars');
        $this->transform(Money::fromNumber(999.99))->shouldBe('nine hundred and ninety nine dollars and ninety nine cents');
        $this->transform(Money::fromNumber(9999.99))->shouldBe('nine thousand nine hundred and ninety nine dollars and ninety nine cents');
        $this->transform(Money::fromNumber(6503.07))->shouldBe('six thousand five hundred and three dollars and seven cents');
        $this->transform(Money::fromNumber(1234.56))->shouldBe('one thousand two hundred and thirty four dollars and fifty six cents');
        $this->transform(Money::fromNumber(8765.43))->shouldBe('eight thousand seven hundred and sixty five dollars and forty three cents');
        $this->transform(Money::fromNumber(987456.1))->shouldBe('nine hundred and eighty seven thousand four hundred and fifty six dollars and ten cents');
    }

    function it_throws_exception_with_large_numbers()
    {
        $exception = new \RuntimeException('Cannot transform large values: 1000000');
        $this->shouldThrow($exception)->during('transform', [Money::fromNumber(1000000)]);
    }
}
