<?php

namespace CanalTP\NavitiaPhp\Tests;

use CanalTP\NavitiaPhp\Navitia;

class NavitiaTest extends \PHPUnit_Framework_TestCase
{
    public function testCall()
    {
        $navitiaBaseUrl = 'http://navitia-base.io/v1/';
        $token = 'my-token';

        $guzzleOptions = [
            'base_uri' => $navitiaBaseUrl,
            'auth' => [$token, ''],
        ];

        $responseMock = $this->getMockForAbstractClass('Psr\\Http\\Message\\ResponseInterface');

        $responseMock
            ->expects($this->any())
            ->method('getBody')
            ->willReturn('{"lines":"expected-lines"}')
        ;

        $clientMock = $this->getMock('GuzzleHttp\\Client', ['get'], [$guzzleOptions]);

        $clientMock
            ->expects($this->once())
            ->method('get')
            ->with('path/endpoint?my_arg=my_value')
            ->willReturn($responseMock)
        ;

        $navitia = new Navitia($clientMock);

        $result = $navitia->call('path/endpoint?my_arg=my_value');

        $this->assertObjectHasAttribute('lines', $result);
        $this->assertEquals('expected-lines', $result->lines);

        $configBaseUri = (string) $clientMock->getConfig('base_uri');
        $this->assertEquals('http://navitia-base.io/v1/', $configBaseUri);
    }
}
