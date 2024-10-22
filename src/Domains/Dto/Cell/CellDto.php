<?php

namespace Masterskill\AfaApiLaravel\Domains\Dto\Cell;

use Masterskill\AfaApiLaravel\Helpers\Centroide;
use App\Models\City;
use Masterskill\AfaApiLaravel\Helpers\Level;

final class CellDto
{
    public static function fromResponse(mixed $cellResponse): mixed
    {
        $cell = [];

        if (!$cellResponse->features)
            return null;
        $properties = $cellResponse->features[0]->properties;
        $coordinates = $cellResponse->features[0]->geometry->coordinates;
        $coordinatesResult = [];

        foreach ($coordinates[0] as $point) {
            $coordinatesResult[] = [
                'lon' => number_format($point[0], 6, '.', ','),
                'lat' => number_format($point[1], 6, '.', ','),
            ];
        }

        $coordinates[0] = $coordinatesResult;

        $centroid = Centroide::calculateCentroid($coordinates[0]);

        $cellResult = City::where('jurisd_local_id', $properties->jurisd_local_id)->first();

        $code = explode('~', $properties->short_code);
        $cell[] = [
            'jurisd_local_id' => $properties->jurisd_local_id,
            'code_b32nvu' => $code[count($code) - 1],
            'l' => Level::getLevelFromResponse($properties->side),
            'polygon' => [
                'type' => 'Polygon',
                'coordinates' => $coordinates
            ],
            'centroide' => [
                'type' => 'Point',
                'coordinates' => $centroid
            ],
            'city' => $cellResult
        ];

        return $cell;
    }
}
