<?php

namespace Masterskill\AfaApiLaravel\Helpers;

class Centroide
{
    public static function calculateCentroid($coordinates)
    {
        $Cx = 0;   // Coordonnée longitude du centroïde
        $Cy = 0;   // Coordonnée latitude du centroïde
        $numPoints = count($coordinates);

        // Calculer la somme des coordonnées en excluant le dernier point (point de fermeture)
        for ($i = 0; $i < $numPoints - 1; $i++) {
            $Cx += floatval($coordinates[$i]['lon']);
            $Cy += floatval($coordinates[$i]['lat']);
        }

        // Calculer la moyenne en divisant par le nombre de points (excluant le point de fermeture)
        $Cx /= ($numPoints - 1);
        $Cy /= ($numPoints - 1);

        // Retourner les coordonnées formatées avec 6 décimales
        return [
            'lon' => number_format($Cx, 6, '.', ''),
            'lat' => number_format($Cy, 6, '.', '')
        ];
    }
}
