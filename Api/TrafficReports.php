<?php

namespace CanalTP\NavitiaPhp\Api;

use CanalTP\NavitiaPhp\Api\Api;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrafficReports extends Api
{
    public function forCoverage()
    {
        return $this->navitia->call('coverage/'. $this->navitia->getDefaultCoverage(). '/traffic_reports');
    }
}