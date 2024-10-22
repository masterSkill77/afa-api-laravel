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

        if (isset($cityResponse->features[0])) {
            $properties = $cityResponse->features[0]->properties;

            $isCity = isset($properties->parent_id);

            $coordinates = $isCity ? $cityResponse->features[0]->geometry->coordinates[0] : $cityResponse->features[0]->geometry->coordinates;
            $coordinatesResult = [];

            foreach ($coordinates[0] as $point) {
                $coordinatesResult[] = [
                    'lon' => number_format($point[0], 6, '.', ','),
                    'lat' => number_format($point[1], 6, '.', ','),
                ];
            }

            $coordinates[0] = $coordinatesResult;

            $centroid = Centroide::calculateCentroid($coordinates[0]);

            $cityResult = City::where('jurisd_local_id', $properties->jurisd_local_id)->first();

            $code = $isCity  ? explode('-', $properties->canonical_pathname) : explode('~', $properties->short_code);
            $city[] = [
                'jurisd_local_id' => $properties->jurisd_local_id,
                'code_b32nvu' => $code[count($code) - 1],
                'l' => $isCity ? null : Level::getLevelFromResponse($properties->side),
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
        }
        return $city;
    }
}
