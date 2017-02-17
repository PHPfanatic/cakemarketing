# Cake Marketing API - CakePHP 3 Plugin

This project is a CakePHP 3 vendor implementation of the Cake Marketing API. ([Getcake](http://getcake.com/)).

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

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.  

Add the package to your composer impelementation
```
composer require phpfanatic/cakemarketing

```

Load the plugin in your CakePHP 3 application.
```
Plugin::load('phpfanatic/cakemarketing');
```

### Prerequisites

You will need an active Cake Marketing account with an active Api key and domain URL.  These need to be setup directly with Cake Marketing.

## Built With

* [CakePHP 3](https://cakephp.org/) - The web framework used
* [Composer](https://getcomposer.org/) - Dependency management
* [PHPUnit](https://phpunit.de/) - Testing framework

## Authors

* **Nick White** - *Initial work* - [PHPfanatic](https://github.com/PHPfanatic)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.
This license is limited to the files associated with this project and does not cover nor affiliated with
Cake Marketing.
