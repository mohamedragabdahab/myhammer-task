<?php

namespace AppBundle\Controller;

use AppBundle\Builder\Job as JobBuilder;
use AppBundle\Services\Job;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;

class JobController extends AbstractController
{
    public function __construct()
    {
        $this->serviceName = Job::class;
        $this->builder = JobBuilder::class;
    }

    /**
     * @Rest\Get("/job")
     *
     * @return View
     */
    public function getAllAction(): View
    {
        return parent::getAllAction();
    }

    /**
     * @Rest\Get("/job/{id}")
     *
     * @param string id
     * @throws NotFoundHttpException
     * @return View
     */
    public function getAction($id): View
    {
        return parent::getAction($id);
    }

    /**
     * @Rest\Post("/job")
     */
    public function postAction(Request $request): View
    {
        return parent::postAction($request);
    }

    /**
     * @Rest\Put("/job/{id}")
     *
     * @param string id
     * @param Request $request
     * @return View
     */
    public function putAction(string $id, Request $request): View
    {
        return parent::putAction($id, $request);
    }
}
