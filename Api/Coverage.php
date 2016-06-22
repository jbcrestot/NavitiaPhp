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
        return $this->navitia->call(array('coverage' => ''));
    }

    /**
     * get info relative to given coverage
     *
     * @param null/string $coverage
     * @return json
     * @throws \Canaltp\NavitiaPhp\Exception\NavitiaException
     */
    public function get($coverage = null)
    {
        if (empty($coverage)) {
            return $this->navitia->call(array('path' => array()));
        }

        return $this->navitia->call(array('path' => array('coverage' => $coverage)));
    }

    public function findByCoords($coords)
    {
        return $this->navitia->call(array('path' => array('coords' => $coords)));
    }
}