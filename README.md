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

## Contributors ✨

Thanks goes to these wonderful people ([emoji key](https://allcontributors.org/docs/en/emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tbody>
    <tr>
      <td align="center" valign="top" width="14.28%"><a href="http://jketelaar.nl/"><img src="https://avatars0.githubusercontent.com/u/3681904?v=4?s=100" width="100px;" alt="Jeroen Ketelaar"/><br /><sub><b>Jeroen Ketelaar</b></sub></a><br /><a href="#maintenance-JKetelaar" title="Maintenance">🚧</a> <a href="https://github.com/JKetelaar/PHP-Kiyoh-API/pulls?q=is%3Apr+reviewed-by%3AJKetelaar" title="Reviewed Pull Requests">👀</a> <a href="https://github.com/JKetelaar/PHP-Kiyoh-API/commits?author=JKetelaar" title="Code">💻</a> <a href="#infra-JKetelaar" title="Infrastructure (Hosting, Build-Tools, etc)">🚇</a> <a href="#ideas-JKetelaar" title="Ideas, Planning, & Feedback">🤔</a></td>
      <td align="center" valign="top" width="14.28%"><a href="https://github.com/menno-ll"><img src="https://avatars0.githubusercontent.com/u/50165380?v=4?s=100" width="100px;" alt="Menno van den Ende"/><br /><sub><b>Menno van den Ende</b></sub></a><br /><a href="https://github.com/JKetelaar/PHP-Kiyoh-API/commits?author=menno-ll" title="Code">💻</a> <a href="#ideas-menno-ll" title="Ideas, Planning, & Feedback">🤔</a></td>
      <td align="center" valign="top" width="14.28%"><a href="http://mediadevs.nl"><img src="https://avatars3.githubusercontent.com/u/38211249?v=4?s=100" width="100px;" alt="Mike van Diepen"/><br /><sub><b>Mike van Diepen</b></sub></a><br /><a href="https://github.com/JKetelaar/PHP-Kiyoh-API/commits?author=mikevandiepen" title="Code">💻</a> <a href="https://github.com/JKetelaar/PHP-Kiyoh-API/commits?author=mikevandiepen" title="Tests">⚠️</a></td>
      <td align="center" valign="top" width="14.28%"><a href="https://github.com/joldnl"><img src="https://avatars.githubusercontent.com/u/4668261?v=4?s=100" width="100px;" alt="joldnl"/><br /><sub><b>joldnl</b></sub></a><br /><a href="https://github.com/JKetelaar/PHP-Kiyoh-API/commits?author=joldnl" title="Code">💻</a></td>
      <td align="center" valign="top" width="14.28%"><a href="http://www.kingsquare.nl/"><img src="https://avatars.githubusercontent.com/u/1492861?v=4?s=100" width="100px;" alt="Robin Speekenbrink"/><br /><sub><b>Robin Speekenbrink</b></sub></a><br /><a href="https://github.com/JKetelaar/PHP-Kiyoh-API/commits?author=fruitl00p" title="Code">💻</a></td>
      <td align="center" valign="top" width="14.28%"><a href="https://github.com/thomasdik1989"><img src="https://avatars.githubusercontent.com/u/7187261?v=4?s=100" width="100px;" alt="Thomas Dik"/><br /><sub><b>Thomas Dik</b></sub></a><br /><a href="https://github.com/JKetelaar/PHP-Kiyoh-API/commits?author=thomasdik1989" title="Code">💻</a></td>
    </tr>
  </tbody>
</table>

<!-- markdownlint-restore -->
<!-- prettier-ignore-end -->

<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/all-contributors/all-contributors) specification. Contributions of any kind welcome!