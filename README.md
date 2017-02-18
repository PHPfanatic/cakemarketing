# Cake Marketing API Library

This project is a psr-4 compliant implementation of the Cake Marketing API. ([Getcake](http://getcake.com/)).

Because of some inconsistencies in the Cake Marketing API not all functions will be supported.  This implementation breaks the Cake Marketing
API into individual classes that follow their naming convention.  Currently listed as:

* Track
* Accounting
* Add
* Addedit
* Auth
* Export
* Edit
* Get
* Reports
* Signup

Currently if you need functionality from multiple classes, you will need to implement them independently.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.  

Add the package to your composer impelementation
```
composer require phpfanatic/cakemarketing

```

I found that in CakePHP I needed to update the composer.json file of the CakePHP app to have the following:
```
 "autoload": {
        "psr-4": {
            "App\\": "src",
            "PhpFanatic\\Cakemarketing\\": "./vendor/phpfanatic/cakemarketing/src"
        }
    },

```


### Prerequisites

You will need an active Cake Marketing account with an active Api key and domain URL.  These need to be setup directly with Cake Marketing.

## Built With

* [Composer](https://getcomposer.org/) - Dependency management
* [PHPUnit](https://phpunit.de/) - Testing framework

## Authors

* **Nick White** - *Initial work* - [PHPfanatic](https://github.com/PHPfanatic)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.
This license is limited to the files associated with this project and does not cover nor affiliated with
Cake Marketing.
