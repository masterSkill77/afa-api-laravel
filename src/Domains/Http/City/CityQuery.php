<?php

namespace Masterskill\AfaApiLaravel\Domains\Http\City;

use Masterskill\AfaApiLaravel\Domains\Dto\City\CityDto;
use Masterskill\AfaApiLaravel\Domains\Http\Base;

class CityQuery extends Base
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Process the input to put in the prefix CM if not present
     * @param string $query The query param
     * @return string The processed input
     */
    protected function processInput(string $query): string
    {
        if (str_starts_with($query, "CM-"))
            return $query . ".json";
        return "CM-" . $query . ".json";
    }

    /**
     * Query through the city endpoint
     * @param string $query The query
     * @return mixed
     */
    public function query(string $query)
    {
        $query = $this->processInput($query);

        $response = json_decode($this->client->get($query)->getBody()->getContents(), false);

        return ($response->features) ? CityDto::fromResponse($response) : null;
    }
}
