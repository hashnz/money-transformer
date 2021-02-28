## Docker

    docker run -ti -v $PWD:/srv -w /srv composer install
    docker run -ti -v $PWD:/srv -w /srv php bash

## Tests
    /srv# ./vendor/bin/phpspec run -f pretty

## CLI
    /srv# ./bin/console.php app:transform-money 123.45
   
## Code

    MoneyTransform::transform(Money::fromNumber(123.45));
