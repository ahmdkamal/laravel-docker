## How to run commands

in your terminal write `docker exec -it parent-aps-php bash` to start using the php container

## Before starting 

in php container run `composer install`

## How to start it

you can call {VIRTUAL_HOST}:{PORT}/api/v1/users

## How to run the test cases

in php container run `./vendor/bin/phpunit`
