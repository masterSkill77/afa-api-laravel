<?php

namespace Masterskill\AfaApiLaravel\Domains\Dto\Cell;

use Masterskill\AfaApiLaravel\Helpers\Centroide;
use App\Models\City;
use Masterskill\AfaApiLaravel\Helpers\Level;

final class CellDto
{
    /**
     * This method transforms cell from AFACode into cell like used in application
     * It stocks all info about the cell, like centroid, jurisd_local_id or it's polygon
     * @param mixed $cellResponse
     * @return array
     */
    public static function fromResponse(mixed $cellResponse): array
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

        $cellResult->l = Level::CITY_LEVEL;

        $code = explode('~', $properties->logistic_id);
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
