<?php

namespace CanalTP\NavitiaPhp\Api;

use Symfony\Component\OptionsResolver\OptionsResolver;
use CanalTP\NavitiaPhp\Api\Api;

class PublicTransportObject extends Api
{
    public function getAll($query = array())
    {
        return $this->getById(null, $query);
    }

    public function getById($objectId, $query = array())
    {
        $this->configureQueryOptions($query);

        return $this->navitia->call(array(
            'path' => array(
                0 => array(
                    'element' => strtolower((new \ReflectionClass($this))->getShortName()),
                    'value' => $objectId
                ),
            ),
            'query' => $query
        ));
    }
    
    public function configureQueryOptions(&$queryOptions)
    {
        $queryResolver = new OptionsResolver();
        $queryResolver->setDefaults(array(
            'depth' => null,
            'distance' => null, // only for coords?
            'headsign' => null,
            'since' => null,
            'until' => null,
            'filter' => null
        ));

        $queryOptions = $queryResolver->resolve($queryOptions);
    }

}