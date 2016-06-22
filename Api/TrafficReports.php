<?php

namespace CanalTP\NavitiaPhp\Api;

use CanalTP\NavitiaPhp\Navitia;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrafficReports {

    private $navitia;

    public function __construct(Navitia $navitia)
    {
        $this->navitia = $navitia;
    }

    public function forCoverage()
    {
        return $this->navitia->call('coverage/'. $this->navitia->getDefaultCoverage(). '/traffic_reports');
    }
}