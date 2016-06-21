<?php

namespace CanalTP\NavitiaPhp\Api;

use CanalTP\NavitiaPhp\Navitia;

class Coverage {

    private $navitia;

    /**
     * Coverage constructor.
     */
    public function __construct(Navitia $navitia)
    {
        $this->navitia = $navitia;
    }

    public function all()
    {
        return $this->navitia->call('coverage');
    }
}