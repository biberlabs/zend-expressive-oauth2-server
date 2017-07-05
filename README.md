## The PHP League OAuth2 Server For Zend Expressive 

## Installation

 - Run `composer install` in this directory to install dependencies
 - Create a private key `openssl genrsa -out private.key 1024`
 - Create a public key `openssl rsa -in private.key -pubout > public.key`
 - Create `data/cache` and `data/db` folders for doctrine cache and SQLite DB file.
 - Copy `config/autoload/doctrine.local.php.dist` file as `config/autoload/doctrine.local.php` and configure yoru database
 - Initialize your database `vendor/bin/doctrine orm:schema-tool:create`
 - Now you should create a sample user and client to simulate example oauth actions. Please run `data/samples/sample_data.sql` file.
 - Run your server with `composer serve`
 - Use `data/samples/postman_collection.json` file to execute sample requests with [Postman](https://www.getpostman.com).

## Some Important Information

For my opinion, Some of the OAuth entities should be moved to redis or similar key value fast storage. Otherwise,
your API or application can be slower than your expectation. Please contact with [me](mailto:haydarkulekci@gmail.com).

## Requests

Check the [The PHP League Example Page](https://github.com/thephpleague/oauth2-server/tree/master/examples)
