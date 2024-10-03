<?php

namespace Masterskill\AfaApiLaravel\Domains\Dto\City;

use Masterskill\AfaApiLaravel\Helpers\Centroide;
use App\Models\City;
use Masterskill\AfaApiLaravel\Helpers\Level;

final class CityDto
{
    public static function fromResponse(mixed $cityResponse): mixed
    {
        $city = [];


        $properties = $cityResponse->features[0]->properties;
        $coordinates = $properties->wikidata_id ? $cityResponse->features[0]->geometry->coordinates[0] : $cityResponse->features[0]->geometry->coordinates;
        $coordinatesResult = [];

        foreach ($coordinates[0] as $point) {
            $coordinatesResult[] = [
                'lon' => $point[0],
                'lat' => $point[1],
            ];
        }

        $coordinates[0] = $coordinatesResult;

        $centroid = Centroide::calculateCentroid($coordinates[0]);

        $cityResult = City::where('jurisd_local_id', $properties->jurisd_local_id)->first();

        $code = explode('~', $properties->short_code);
        $city[] = [
            'jurisd_local_id' => $properties->jurisd_local_id,
            'code_b32nvu' => $code[count($code) - 1],
            'l' => Level::getLevel($properties->side),
            'polygon' => [
                'type' => 'Polygon',
                'coordinates' => $coordinates
            ],
            'centroide' => [
                'type' => 'Point',
                'coordinates' => $centroid
            ],
            'city' => $cityResult
        ];

        return $city;
    }
}
