<?php

namespace CanalTP\NavitiaPhp;

use Psr\Log\LoggerInterface;
use CanalTP\AbstractGuzzle\Guzzle;
use CanalTP\AbstractGuzzle\GuzzleFactory;
use CanalTP\NavitiaPhp\Exception\NavitiaException;

class Navitia
{
    /**
     * @var Guzzle
     */
    private $httpClient;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string|null
     */
    private $defaultCoverage;

    /**
     * Navitia constructor.
     * @param Guzzle $httpClient
     * @param string|null $defaultCoverage
     * @param string|null $defaultToken
     */
    public function __construct(Guzzle $httpClient, LoggerInterface $logger = null, $defaultCoverage = null)
    {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
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
        $httpClient = GuzzleFactory::createClient(
            $navitiaBaseUrl,
            ['auth' => [$token, '']]
        );

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
        // in case of modification, we are warning user
        if ($this->logger && $this->defaultCoverage !== $defaultCoverage) {
            $this->logger->warning('don\'t forget to instantiate new QueryBuilder after setting new defaultCoverage');
        }

        $this->defaultCoverage = $defaultCoverage;

        return $this;
    }

    /**
     * @param string $path
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
        } catch (\Exception $e) {
            throw new NavitiaException($e->getMessage(), $e);
        }
    }
}
