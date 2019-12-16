<?php

namespace App\Controller;

use App\Service\AbstractService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class AbstractController extends AbstractFOSRestController
{
    /**
     * @var AbstractService
     */
    protected $service;

    /**
     * @var string
     */
    protected $builder;

    /**
     * @return View
     */
    public function getAllAction(): View
    {
        return new View(
            $this->service->findAll(),
            Response::HTTP_OK
        );
    }

    /**
     * @param $id
     * @return View
     */
    public function getAction($id): View
    {
        $entity = $this->service->find($id);
        if (!$entity) {
            throw new NotFoundHttpException(sprintf(
                'The resource \'%s\' was not found.',
                $id
            ));
        }

        return new View(
            $entity,
            Response::HTTP_OK
        );
    }

    /**
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request): View
    {
        $parameters = $request->request->all();
        $entity = $this->builder::build($parameters);
        $persistedEntity = $this->service->create($entity);

        return new View(
            $persistedEntity,
            Response::HTTP_CREATED
        );
    }

    public function putAction(string $id, Request $request): View
    {
        $params = $request->request->all();
        $params['id'] = $id;
        $entity = $this->builder::build($params);
        $persistedEntity = $this->service->update($entity);

        return new View(
            $persistedEntity,
            Response::HTTP_OK
        );
    }
}
