<?php

namespace CanalTP\NavitiaPhp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use CanalTP\NavitiaPhp\Exception\NavitiaException;

class Navitia
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * Navitia constructor.
     *
     * @param Client $httpClient
     */
    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $navitiaBaseUrl
     * @param string $token
     *
     * @return self
     */
    public static function createFromBaseUrlAndToken($navitiaBaseUrl, $token)
    {
        $httpClient = new Client([
            'base_uri' => $navitiaBaseUrl,
            'auth' => [$token, ''],
        ]);

        return new self($httpClient);
    }

    /**
     * @return Client
     */
    public function getGuzzleClient()
    {
        return $this->httpClient;
    }

    /**
     * @param Client $httpClient
     *
     * @return self
     */
    public function setGuzzleClient(Client $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * @param sring $path
     *
     * @return \stdClass
     *
     * @throws NavitiaException
     */
    public function call($path)
    {
        try {
            $result = $this->httpClient->get($path);

            return json_decode($result->getBody());
        } catch (ClientException $e) {
            throw new NavitiaException($e->getMessage(), $e);
        }
    }
}
