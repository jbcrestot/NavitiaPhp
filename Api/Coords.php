<?php

namespace CanalTP\NavitiaPhp\Api;

use CanalTP\NavitiaPhp\Api\Api;

class Coords extends Api
{
    /**
     * @param $coords
     * @return mixed
     * @throws \CanalTP\NavitiaPhp\Exception\NavitiaException
     */
    public function getInformations($coords)
    {
        return $this->navitia->call(array('path' => array(
            0 => array(
                'element' => 'coords',
                'value'   => $coords
            )
        )));
    }

    public function getClosePois($coords, array $query)
    {
        return $this->navitia->call(array(
            'path' => array(
                0 => array(
                    'element' => 'coords',
                    'value'   => $coords
                ),
                1 => array(
                    'element' => 'pois'
                )
            ),
            'query' => $query

        ));
    }
}