<?php

namespace CanalTP\NavitiaPhp\Api;

use CanalTP\NavitiaPhp\Navitia;

class Api {

    protected $navitia;

    /**
     * Coords constructor.
     * @param Navitia $navitia
     */
    public function __construct(Navitia $navitia)
    {
        $this->navitia = $navitia;
    }
}