<?php

namespace CanalTP\NavitiaPhp\Api;

use CanalTP\NavitiaPhp\Api\PublicTransportObject;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Lines extends PublicTransportObject
{

    public function configureQueryOptions(&$queryOptions)
    {
        $queryResolver = new OptionsResolver();
        $queryResolver->setDefaults(array(
            'odt_level' => null, // only for lines
        ));

        $queryOptions = $queryResolver->resolve($queryOptions);

        parent::configureQueryOptions($queryOptions);
    }
}