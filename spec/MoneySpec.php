<?php

namespace spec\App;

use App\Money;
use PhpSpec\ObjectBehavior;

class MoneySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(1,2);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Money::class);
    }

    function it_constructs_from_float_string()
    {
        $this->beConstructedThrough('fromNumber', ['1.23']);
        $this->getDollars()->shouldBe(1);
        $this->getCents()->shouldBe(23);
    }

    function it_constructs_from_int_string()
    {
        $this->beConstructedThrough('fromNumber', ['120']);
        $this->getDollars()->shouldBe(120);
        $this->getCents()->shouldBe(0);
    }

    function it_constructs_from_float()
    {
        $this->beConstructedThrough('fromNumber', [54.1]);
        $this->getDollars()->shouldBe(54);
        $this->getCents()->shouldBe(10);
    }

    function it_constructs_from_int()
    {
        $this->beConstructedThrough('fromNumber', [99]);
        $this->getDollars()->shouldBe(99);
        $this->getCents()->shouldBe(0);
    }

    function it_rounds_numbers()
    {
        $this->beConstructedThrough('fromNumber', [654.126]);
        $this->getDollars()->shouldBe(654);
        $this->getCents()->shouldBe(13);
    }

    function it_throws_exception_when_non_numeric()
    {
        $this->beConstructedThrough('fromNumber', ['1nope']);
        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }
}
