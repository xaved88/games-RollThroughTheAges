<?php

namespace RTTA\TestsFunctional;

use PHPUnit\Framework\TestCase;

abstract class BaseFunctional extends TestCase
{
    const PROJECT_WEB_URL = 'http://rollthroughtheages.games.wtf';

    protected function makeServiceCall($service, $method, $params = [])
    {

        $url = $this->buildUrl($service, $method);


        $postdata = http_build_query(['params' => $params]);

        $opts = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata,
            ],
        ];

        $context = stream_context_create($opts);

        return file_get_contents($url, false, $context);
    }

    /**
     * @param $service
     * @param $method
     *
     * @return string
     */
    protected function buildUrl($service, $method):string
    {
        return static::PROJECT_WEB_URL . "/api/" . $service . "/" . $method;
    }
}