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

    /**
     * Navitia constructor.
     */
    public function __construct(Client $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function call($NavitiaRequest)
    {
        try
        {
            $result = $this->guzzle->get($NavitiaRequest);
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