<?php

namespace CanalTP\NavitiaPhp\Tests;

use CanalTP\AbstractGuzzle\GuzzleFactory;
use CanalTP\NavitiaPhp\Navitia;
use GuzzleHttp\Psr7\Response;

class NavitiaTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromBaseUrl()
    {
        $baseUri = 'http://www.navitia.io/';
        $token = 'thisisnotavalidtoken';
        $navitia = Navitia::createFromBaseUrlAndToken($baseUri, $token);

        $this->assertNull($navitia->getDefaultCoverage());
        $this->assertEquals($baseUri, $navitia->getGuzzleClient()->getBaseUri());
        $this->assertEquals($token, $navitia->getGuzzleClient()->getDefaultOptions()['auth'][0]);
    }

    public function testCreateQueryBuilderWithDefaultCoverage()
    {
        $navitia = new Navitia(GuzzleFactory::createClientMock([]), null, 'default-coverage');

        $queryBuilder = $navitia->createQueryBuilder();

        $this->assertContains('default-coverage', $queryBuilder->getQuery());
    }

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
    
    public function testCallFail()
    {
        $clientMock = GuzzleFactory::createClientMock([
            new Response(500, [], '{"lines":"expected-lines"}'),
        ]);

        $navitia = new Navitia($clientMock);
        try
        {
            $navitia->call('lines');
        }
        catch (\exception $e) {
            $this->assertInstanceOf('CanalTP\NavitiaPhp\Exception\NavitiaException', $e);
        }
    }


//    public function testRealCase()
//    {
//        $baseUri = 'https://api.navitia.io/v1/';
//        $token = '810f0043-055f-4ced-a49d-701e3ebd36d2';
//        $navitia = Navitia::createFromBaseUrlAndToken($baseUri, $token);
//        $test = $navitia->call('coverage/fr-idf/');
//        var_dump($test);
//        $this->assertEquals('json', $test);
//    }
}
