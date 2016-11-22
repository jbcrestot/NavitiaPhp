<?php

namespace CanalTP\NavitiaPhp;

use CanalTP\AbstractGuzzle\Guzzle;
use CanalTP\AbstractGuzzle\GuzzleFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use CanalTP\NavitiaPhp\Exception\NavitiaException;
use CanalTP\NavitiaPhp\QueryBuilder;

class Navitia
{
    /**
     * @var Client
     */
    private $httpClient;

    /**
     * @var string|null
     */
    private $defaultCoverage;

    /**
     * Navitia constructor.
     * @param Guzzle $httpClient
     * @param null $defaultCoverage
     */
    public function __construct(Guzzle $httpClient, $defaultCoverage = null)
    {
        $this->httpClient = $httpClient;
        $this->defaultCoverage = $defaultCoverage;
    }

    /**
     * @param string $navitiaBaseUrl
     * @param string $token
     *
     * @return self
     */
    public static function createFromBaseUrlAndToken($navitiaBaseUrl, $token)
    {
        $httpClient = GuzzleFactory::createClient($navitiaBaseUrl,[
            'auth' => [$token, ''],
        ]);

        return new self($httpClient);
    }

    /**
     * @return QueryBuilder
     */
    public function createQueryBuilder()
    {
        $queryBuilder = new QueryBuilder();

        if (null !== $this->defaultCoverage) {
            $queryBuilder->coverage($this->defaultCoverage);
        }

        return $queryBuilder;
    }

    /**
     * @return Guzzle
     */
    public function getGuzzleClient()
    {
        return $this->httpClient;
    }

    /**
     * @param Guzzle $httpClient
     *
     * @return self
     */
    public function setGuzzleClient(Guzzle $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDefaultCoverage()
    {
        return $this->defaultCoverage;
    }

    /**
     * @param string|null $defaultCoverage
     *
     * @return self
     */
    public function setDefaultCoverage($defaultCoverage)
    {
        $this->defaultCoverage = $defaultCoverage;

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
