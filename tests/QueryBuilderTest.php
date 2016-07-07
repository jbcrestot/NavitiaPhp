<?php

namespace CanalTP\NavitiaPhp\Tests;

use CanalTP\NavitiaPhp\QueryBuilder;

class QueryBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetQueryWithNothing()
    {
        $queryBuilder = new QueryBuilder();

        $query = $queryBuilder->getQuery();

        $this->assertEquals('', $query);
    }

    public function testGetQueryWithCoverage()
    {
        $queryBuilder = new QueryBuilder();

        $query = $queryBuilder
            ->coverage('fr-idf')
            ->getQuery()
        ;

        $this->assertEquals('coverage/fr-idf', $query);
    }

    public function testGetQueryWithTrafficReports()
    {
        $queryBuilder = new QueryBuilder();

        $query = $queryBuilder
            ->api('traffic_reports')
            ->coverage('fr-idf')
            ->getQuery()
        ;

        $this->assertEquals('coverage/fr-idf/traffic_reports', $query);
    }
}
