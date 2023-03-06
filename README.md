# Symfony-ecommerce-example

This is a test project for to create a REST API with JWT authentication.

## Requirements

  * PHP 8.1.0 or higher;
  * PDO-SQLite PHP extension enabled;
  * and the [usual Symfony application requirements][2].

## Setup

Clone or download the project in a folder and then install dependencies using composer:

```bash
    $ cd Symfony-ecommerce-example
    $ composer install
```

create data base and run all migrations:

```bash
    $ php bin/console doctrine:migrations:migrate 
```


Next run a local web server using the next command:

```bash
    $ symfony server:start
```
Next run a load fixtures using the next command:

```bash
    $ symfony console doctrine:fixtures:load  

```

## Tests

You can execute the tests running the next command:

```bash

    $ vendor/bin/phpunit
```


## API documentation

- https://localhost:8000/docs

## Author

* **Jaafer ABDAOUI** 

