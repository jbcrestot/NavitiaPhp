<?php

namespace CanalTP\NavitiaPhp\Api;

use CanalTP\NavitiaPhp\Navitia;

class Coverage {

    private $navitia;
    private $defaultCoverage;

    /**
     * Coverage constructor.
     */
    public function __construct(Navitia $navitia)
    {
        $this->navitia = $navitia;
        $this->defaultCoverage = $navitia->getCoverge();
    }

    public function all()
    {
        return $this->navitia->call('coverage');
    }

    public function get($coverage = null)
    {
        if (is_null($coverage)) {
            $coverage = $this->defaultCoverage;
        }

        return $this->navitia->call('coverage/'.$coverage);
    }
}