<?php

namespace Masterskill\AfaApiLaravel\Domains\Http\Cell;

use Masterskill\AfaApiLaravel\Domains\Dto\Cell\CellDto;
use Masterskill\AfaApiLaravel\Domains\Http\Base;
use Masterskill\AfaApiLaravel\Helpers\Level;

class CellByGeoQuery extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Process the input from lon / lat format into something accepted by AFACode API
     * @param float $lon The longitude
     * @param float $lat The latitude
     * @param ?int $level From which level we want to search this area
     * @return string The proccessed input to be passed into AFACode API
     */
    protected function processInput(float $lon, float $lat, ?int $level = null): string
    {
        $level = Level::getLevel($level);
        return "/geo:" . $lat . "," . $lon . ($level ? ";u=" . $level : "") . ".json";
    }

    public function query(float $lon, float $lat, ?int $level = null)
    {
        $query = $this->processInput($lon, $lat, $level);

        $response = json_decode($this->client->get($query)->getBody()->getContents(), false);

        return isset($response->features) ? CellDto::fromResponse($response) : null;
    }
}
