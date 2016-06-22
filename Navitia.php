<?php

namespace CanalTP\NavitiaPhp;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\OptionsResolver\OptionsResolver;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Canaltp\NavitiaPhp\Exception\NavitiaException;

class Navitia
{
    private $guzzle;
    private $defaultCoverage;

    /**
     * Navitia constructor.
     */
    public function __construct(Client $guzzle, $coverage)
    {
        $this->guzzle = $guzzle;
        $this->defaultCoverage = $coverage;
    }

    /**
     * @return mixed
     */
    public function getDefaultCoverage()
    {
        return $this->defaultCoverage;
    }

    public function call($options)
    {
        try
        {
            $this->configureOptions($options);

            $result = $this->guzzle->get($this->buildUrl($options));
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

    public function configureOptions(&$options)
    {

        $resolver = new OptionsResolver();
        $resolver->setDefaults(array(
            'coverage' => $this->defaultCoverage,
            'path'     => null,
            'parameters' => null
        ));

        $options = $resolver->resolve($options);
    }

    private function buildUrl($options)
    {
        $url = 'coverage/'. $options['coverage'] .'/';

        if (!empty($options['coverage'])) {
            foreach ($options['path'] as $item) {
                $url += $item['element'] .'/'. $item['value']. '/';
            }
        }

        if (!empty($options['parameters'])) {
            foreach ($options['parameters'] as $item) {
                $url += $item['element'] .'/'. $item['value'];
            }
        }

        return $url;
    }
}