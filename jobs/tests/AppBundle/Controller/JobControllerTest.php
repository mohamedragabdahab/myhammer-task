<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class JobControllerTest extends AbstractControllerTest
{
    /**
     * @var array
     */
    private $defaultJob;

    public function setUp()
    {
        parent::setUp();
        $this->loadServiceFixtures();
        $this->loadZipcodeFixtures();
        $this->loadJobFixtures();
        $this->defaultJob = [
            'serviceId' => 804040,
            'zipcodeId' => '10115',
            'title' => 'title',
            'description' => 'decription',
            'dateToBeDone' => '2018-11-11',
            'id' => 'a961c741-1c32-11ea-bfc6-0242ac130003'
        ];
    }

    public function testGetAllJobs(): void
    {
        $this->client->request('GET', '/job');

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testGetOneJobFound(): void
    {
        $expected = '{"id":"a961c741-1c32-11ea-bfc6-0242ac130003","service_id":804040,"zipcode_id":"10115","title":"title","description":"decription","date_to_be_done":"2018-11-11T00:00:00+00:00"}';

        $this->client->request('GET', '/job/a961c741-1c32-11ea-bfc6-0242ac130003');

        $actualResponse = json_decode($this->client->getResponse()->getContent(), true);
        unset($actualResponse['created_at']);
        $actualResponse = json_encode($actualResponse);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertEquals($expected, $actualResponse);
    }

    public function testGetOneJobNotFound(): void
    {
        $this->client->request('GET', '/job/1');

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testPostInvalidJobReturnsBadRequest(): void
    {
        $this->defaultJob['title'] = '';

        $this->client->request(
            'POST',
            '/job',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($this->defaultJob)
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function testPostJobWithServiceNotFoundReturnsBadRequest(): void
    {
        $this->defaultJob['serviceId'] = 12345;

        $this->client->request(
            'POST',
            '/job',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($this->defaultJob)
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function testPostJobWithZipcodeNotFoundReturnsBadRequest(): void
    {
        $this->defaultJob['zipcodeId'] = '12345';

        $this->client->request(
            'POST',
            '/job',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($this->defaultJob)
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
    }

    public function testPostValidJobNewJobIsCreated(): void
    {
        $this->client->request(
            'POST',
            '/job',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($this->defaultJob)
        );

        $this->assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
    }

    public function testPutWithNotFoundJobReturnsNotFound(): void
    {
        $this->client->request(
            'PUT',
            '/job/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($this->defaultJob)
        );

        $this->assertEquals(Response::HTTP_NOT_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testPutWithValidJobReturnsNotFound(): void
    {
        $id = $this->getFirstJobId();
        $this->client->request(
            'PUT',
            '/job/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($this->defaultJob)
        );

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    private function getFirstJobId(): string
    {
        $this->client->request('GET', '/job');
        $allJobs = json_decode($this->client->getResponse()->getContent(), true);
        $id = $allJobs[0]['id'];

        return $id;
    }
}
