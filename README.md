# A PHP Kiyoh API

This is a fork of the (PHP-Kiyoh-API package)[https://github.com/JKetelaar/PHP-Kiyoh-API]. 
This package adds a timeout param to be passed to the Kiyoh instance. This allows the user to set a max duration of the fetch operation and prevent long response times when Kiyoh api is (partially) down.
## How to install?
Install this project using composer: `composer require vergelijkgroep/php-kiyoh-api`.

Then start using the API using something like:

```php
<?php
/**
 * @author Keuze.nl
 */
require_once('vendor/autoload.php');

$connector = 'xxxxxxxx'; // Change with your hash
$count = 50; // Amount of reviews you want to get
$timeout = 2; // Max duration in seconds of the fetch operation

$kiyoh = new \keuze\Kiyoh\Kiyoh($connector, $count, $timeout);

try {
    $company = $kiyoh->getCompany();
} catch (\Throwable $th) {
    // Handle errors
    echo $th->getMessage();
    //throw $th;
}

$company = $kiyoh->getCompany();

var_dump($company->getReviews()[0]->getId());

var_dump($company->getLocationName());
var_dump($company->getAverageRating());
var_dump($company->getNumberReviews());
```

### Example outputs

#### Company output
```php
var_dump($kiyoh->getCompany());
```
![KiyOh Company PHP Dump](docs/company_dump.png)


#### Review output
```php
var_dump($kiyoh->getCompany()->getReviews()[0]);
```
![KiyOh Company PHP Dump](docs/review_dump.png)
