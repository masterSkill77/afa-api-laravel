<?php

namespace Masterskill\AfaApiLaravel\Domains\Http;

use GuzzleHttp\Client;

class Base
{
    const BASE_URL = "https://api.test.afa.codes";

    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            "base_uri" => Base::BASE_URL
        ]);
    }
}
