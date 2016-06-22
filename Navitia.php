<?php

namespace CanalTP\NavitiaPhp;

use Canaltp\NavitiaPhp\Exception\NavitiaException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Symfony\Component\Yaml\Yaml;

class Navitia
{
    private $guzzle;
    private $coverge;

    /**
     * Navitia constructor.
     */
    public function __construct(Client $guzzle, $coverage)
    {
        $this->guzzle = $guzzle;
        $this->coverge = $coverage;
    }

    /**
     * @return mixed
     */
    public function getCoverge()
    {
        return $this->coverge;
    }

    public function call($NavitiaApi)
    {
        try
        {
            $result = $this->guzzle->get($NavitiaApi);
            if (200 !== $result->getStatusCode()) {
                throw new NavitiaException();
            }
            
            return Yaml::parse((string) $result->getBody());
        }
        catch (ClientException $e) {
            dump('verify your request : 404');
            dump($e);
        }
        catch (ServerException $e) {
            dump('Navitia is down : 500');
            dump($e);
        }
        catch (RequestException $e) {
            dump('Something wrong happen');
            dump($e);
        }
    }
}