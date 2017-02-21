# Cake Marketing API Library
[![Build Status](https://travis-ci.org/PHPfanatic/cakemarketing.svg?branch=master)](https://travis-ci.org/PHPfanatic/cakemarketing)

This project is a psr-4 compliant implementation of the Cake Marketing API. ([Getcake](http://getcake.com/)).

This implementation breaks the Cake Marketing API into individual classes that follow their naming convention.

Cake Marketing API supports Soap 1.1, Soap 1.2, GET and POST.  This project uses HTTP GET for each call.  Use caution in requesting large data sets, if you are unable to retrieve data because of OOM errors consider using row limiters with row start.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.  

Add the package to your composer impelementation
```
composer require phpfanatic/cakemarketing

```

If you are using CakePHP you may need to update the composer.json file of the CakePHP app to have the following for namespacing to work correctly:
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

### Example Usage

```
use PhpFanatic\Cakemarketing\Get;
use PhpFanatic\Cakemarketing\Track;

//Get API
$getApi = new Get('ABC123', 'http://yourportalurl.com');
$data = ['lead_id'=>'ID123ABC'];
$xml = $getApi->ApiCall('LeadInfo', $data);

//Track API
$trackApi = new Track('ABC123', 'http://yourportalurl.com');
$xml = $trackApi->ApiCall('AcceptedDispositions');
```

##Documentation
The goal is to document features and functionality for this library through our GitHub Wiki for this project.  For Cake Marketing API documentation, you should reference their site directly.
([Cake Marketing API Documentation](https://support.getcake.com/support/solutions/5000109264))
* [Track](https://github.com/PHPfanatic/cakemarketing/wiki/Track-Documentation)
* Accounting
* Add
* Addedit
* Auth
* Export
* Edit
* Get
* Reports
* Signup

## Built With

* [Composer](https://getcomposer.org/) - Dependency management
* [PHPUnit](https://phpunit.de/) - Testing framework

## Authors

* **Nick White** - *Initial work* - [PHPfanatic](https://github.com/PHPfanatic)

## License

This project is licensed under the MIT License.
This license is limited to the files associated with this project and does not cover nor affiliated with
Cake Marketing.
