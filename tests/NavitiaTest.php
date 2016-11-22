<?php

namespace CanalTP\NavitiaPhp\Tests;

use CanalTP\AbstractGuzzle\GuzzleFactory;
use CanalTP\NavitiaPhp\Navitia;
use GuzzleHttp\Psr7\Response;

class NavitiaTest extends \PHPUnit_Framework_TestCase
{
    public function testCall()
    {
        $clientMock = GuzzleFactory::createClientMock([
            new Response(200, [], '{"lines":"expected-lines"}'),
        ]);

        $navitia = new Navitia($clientMock);
        $result = $navitia->call('path/endpoint?my_arg=my_value');

        $this->assertObjectHasAttribute('lines', $result);
        $this->assertEquals('expected-lines', $result->lines);
    }

    public function testCreateQueryBuilderWithDefaultCoverage()
    {
        $navitia = new Navitia(GuzzleFactory::createClientMock([]), 'default-coverage');

        $queryBuilder = $navitia->createQueryBuilder();

        $this->assertContains('default-coverage', $queryBuilder->getQuery());
    }
}
