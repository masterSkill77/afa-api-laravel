<?php

namespace Masterskill\AfaApiLaravel\Helpers;

class Centroide
{
    public static function calculateCentroid($coordinates)
    {
        $area = 0; // L'aire du polygone
        $Cx = 0;   // Coordonnée x du centroïde
        $Cy = 0;   // Coordonnée y du centroïde
        $numPoints = count($coordinates);

        // Calculer l'aire et les coordonnées du centroïde
        for ($i = 0; $i < $numPoints - 1; $i++) {
            $x1 = $coordinates[$i]['lon'];
            $y1 = $coordinates[$i]['lat'];
            $x2 = $coordinates[$i + 1]['lon'];
            $y2 = $coordinates[$i + 1]['lat'];

            $crossProduct = ($x1 * $y2) - ($x2 * $y1);
            $area += $crossProduct;
            $Cx += ($x1 + $x2) * $crossProduct;
            $Cy += ($y1 + $y2) * $crossProduct;
        }

        // Terminer l'aire et les coordonnées du centroïde
        $area /= 2;
        $Cx /= (6 * $area);
        $Cy /= (6 * $area);

        return ['lon' => $Cx, 'lat' => $Cy];
    }
}
