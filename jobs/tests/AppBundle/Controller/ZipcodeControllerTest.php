<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class ZipcodeControllerTest extends AbstractControllerTest
{
    public function setUp()
    {
        parent::setUp();
        $this->loadZipcodeFixtures();
    }

    public function testGetAllZipcodes(): void
    {
        $expected = file_get_contents('tests/Fixtures/zipcodes.json');

        $this->client->request('GET', '/zipcode');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertEquals($expected, $this->client->getResponse()->getContent());
    }

    public function testGetOneZipcodeFound(): void
    {
        $expected = '{"id":"01623","city":"Lommatzsch"}';

        $this->client->request('GET', '/zipcode/01623');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertEquals($expected, $this->client->getResponse()->getContent());
    }

    public function testGetOneZipcodeNotFound(): void
    {
        $this->client->request('GET', '/zipcode/1');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testPostZipcodeRepeatedReturnsBadRequest(): void
    {
        $this->client->request(
            'POST',
            '/zipcode',
            [],
            [],
            ['CONTENT-TYPE' => 'application/json'],
            '{"id": "01623", "city": "Lommatzsch"}'
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function testPostInvalidZipcodeReturnsBadRequest(): void
    {
        $this->client->request(
            'POST',
            '/zipcode',
            [],
            [],
            ['CONTENT-TYPE' => 'application/json'],
            '{"id": "123", "city": ""}'
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function testPostValidZipcodeReturnsCreated(): void
    {
        $this->client->request(
            'POST',
            '/zipcode',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"id": "12345", "city": "Valid city"}'
        );

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }
}
