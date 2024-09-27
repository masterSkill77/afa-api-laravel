<?php

namespace Masterskill\AfaApiLaravel\Domains\Http\Cell;

use Masterskill\AfaApiLaravel\Domains\Dto\Cell\CellDto;
use Masterskill\AfaApiLaravel\Domains\Http\Base;

class CellByGeoQuery extends Base
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function processInput(float $lon, float $lat): string
    {
        return "/geo:" . $lat . "," . $lon . ".json";
    }

    public function query(float $lon, float $lat)
    {
        $query = $this->processInput($lon, $lat);

        $response = json_decode($this->client->get($query)->getBody()->getContents(), false);

        return ($response->features) ? CellDto::fromResponse($response) : null;
    }
}
