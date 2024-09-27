# AFAcodes Cameroon API

# API v0.2.1 from the AFACodes

<p>
Endpoints and functionalities of the Logistic Grid, syntax “CM-$etc”. For Scientific Grid (syntax “CM+$etc”) and covers, see next documentation. We use, instead a Swagger, the “page endpoint” that is self-explanatory.
</p>

# Installation

With composer

```bash
composer require masterskill/afa-code-laravel
```

## City Querying

For querying a city, you should initialize the cityQuery class.

Make sure you have the App\Models\City on the project.

```php
use Masterskill\AfaApiLaravel\Domains\Http\City\CityQuery;

$cityQuery = new CityQuery();

$query ="CM-SOA";

$result = $cityQuery->query($query);

print_r($cityQuery);

```
