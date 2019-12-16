<?php

namespace App\Controller;

use App\Builder\Zipcode as ZipcodeBuilder;
use App\Service\Zipcode as ZipcodeService;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\Annotations as Rest;

class ZipcodeController extends AbstractController
{
    public function __construct(ZipcodeService $zipcodeService)
    {
        $this->service = $zipcodeService;
        $this->builder = ZipcodeBuilder::class;
    }

    /**
     * @Rest\Get("/zipcode")
     * @return View
     */
    public function getAllAction(): View
    {
        return parent::getAllAction();
    }

    /**
     * @Rest\Get("/zipcode/{id}")
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
     * @Rest\Post("/zipcode")
     */
    public function postAction(Request $request): View
    {
        return parent::postAction($request);
    }
}
