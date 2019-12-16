<?php

namespace App\Controller;

use App\Builder\Service as ServiceBuilder;
use App\Service\Service as ServiceService;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;

class ServiceController extends AbstractController
{
    public function __construct(ServiceService $serviceService)
    {
        $this->service = $serviceService;
        $this->builder = ServiceBuilder::class;
    }

    /**
     * @Rest\Get("/service")
     * @return View
     */
    public function getAllAction(): View
    {
        return parent::getAllAction();
    }

    /**
     * @Rest\Get("/service/{id}")
     *
     * @param int id
     * @throws NotFoundHttpException
     * @return View
     */
    public function getAction($id): View
    {
        return parent::getAction($id);
    }

    /**
     * @Rest\Post("/service")
     */
    public function postAction(Request $request): View
    {
        return parent::postAction($request);
    }
}
