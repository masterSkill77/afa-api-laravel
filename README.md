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

## Level

For the level correspondance, it depends on the side you want it.<br/>
From application, we use all these level, that is all the point of view from the user :</br>

<ul>
<li>180 : 1m</li>
<li>155 : 6m</li>
<li>130 : 30m</li>
<li>105 : 200m</li>
<li>80 : 1km</li>
</ul>

## Side

From AFACode, there is no level defined. Instead, they use side for the point of view.<br/>
With that, we need to make sure we transform all level into side<br/>
Below the SIDE and LEVEL relation.

<ul>
<li>0.5 : 180</li>
<li>2.5 : 155</li>
<li>16 : 130</li>
<li>90.5 : 105</li>
<li>512 : 80</li>
</ul>

To push it a little further, below the calculation.

```php
    switch (($side)) {
        case $side < 2.5:
            return 180;
        case    2.5 <= $side && $side < 15:
            return 155;
        case 15 <= $side && $side < 100:
            return 130;
        case 100 <= $side && $side < 600:
            return 105;
        case 600 <= $side:
            return 80;
    }
```

## Centroid

Each city or point in the API will be assigned a centroid. This centroid can be used everywhere, but you can be sure there is always this centroid.
You can calculate the centroid of point dirrectly too, but make sure to have the coordinatees in form of an array of lon / lat object.

To calculate it manually, you have the helper `\Masterskill\AfaApiLaravel\Helpers\Centroide`, and call `calculateCentroid` method statically.

## Cell

A cell is a portion of territory in the AFACode API. You can get the cell either with the longitude and lattitude or directly with the BANOC code directly, both will generate a cell. The difference is that we often use the BANOC Code if we search a city or something we know the format, and we use the GeoQuery if we want to use a lon / lat format.

Make sure you instanciate the `CellByGeoQuery` class before using it.
When you pass the lon and lat and eventually the level, for exemple lon : 11.20524 and lat : 1.6580, it will be processed to make sure that the request will be valid in the AFACode API.

## Thanks

Thanks for AFACode for their beautifull API.
You can check their tools at <a href='https://afa.codes'>https://afa.codes</a>.

For example, in Yaoundé region, we can have <a href='https://afa.codes/CM-YE4-6DS'>https://afa.codes/CM-YE4-6DS</a>
