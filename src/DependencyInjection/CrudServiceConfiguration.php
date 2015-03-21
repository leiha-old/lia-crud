<?php

namespace Lia\CrudBundle\DependencyInjection;

use Doctrine\Common\Persistence\ObjectRepository;
use Lia\KernelBundle\Controller\ControllerBase;
use Lia\CrudBundle\Controller\CrudController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Form;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CrudServiceConfiguration
{

    private $routesPrefix = 'lia_crud_';

    /**
     * @var Array
     */
    private $routes = array();

    /**
     * @var Array
     */
    private $routesKeys = [
        'create',
        'edit',
        'delete',
        'show',
        'index',
    ];

    /**
     * @var CrudController
     */
    public $controller;

    /**
     * @var Form The form
     */
    private $form;

    /**
     * @var AbstractType
     */
    private $formType;

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager|object
     */
    protected $entityManager;


    protected $entity;

    /**
     * Name Of the entity (Symfony Like : AcmeBundle:Entity)
     * @var string
     */
    protected $entityName;

    /**
     * @var ObjectRepository
     */
    protected $entityRepository;

    public function __construct(CrudController $controller)
    {
        $this->setController($controller);
        $controller->setConfiguration($this);
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getRoute(
        $route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH
    )
    {
        if (in_array($route, $this->routesKeys)) {
            $route = isset($this->routes[$route])
                ? $this->routes[$route]
                : $this->routesPrefix . $route;
        }
        return $this->controller->generateUrl($route, $parameters, $referenceType);
    }

    public function setRoutesPrefix($routePrefix, $separator = '_')
    {
        $this->routesPrefix = $routePrefix . $separator;
        return $this;
    }

    public function setRoutes(Array $routes)
    {
        $this->routes = $routes;
        return $this;
    }

    public function addRoute($route, $path)
    {
        $this->routes[$route] = $path;
        return $this;
    }

    /**
     * @var string $entityName
     * @return $this
     */
    public function setEntity($entityName)
    {
        $this->entityName = $entityName;
        $this->entityManager = $this->controller->getDoctrine()->getManager();
        $this->entityRepository = $this->entityManager->getRepository($entityName);
        //$this->entity      = new $entityName();
        return $this;
    }

    /**
     * @param null $id
     * @return object
     */
    public function getEntity($id = null)
    {
        if (!$id) {
            $entity = new $this->entityName();
        } elseif (is_object($id)) {
            $entity = $id;
        } elseif (!$entity = $this->entityRepository->find($id)) {
            throw $this->controller->createNotFoundException('Unable to find entity.');
        }
        return $entity;
    }

    public function setController(ControllerBase $controller)
    {
        $this->controller = $controller;
        return $this;
    }

    /**
     * @param string $route
     * @param int|object|null $id
     * @param string $method
     * @param array $config
     * @return Form
     */
    public function getEntityForm($route, $id = null, $method = 'POST', array $config = array())
    {
        return $this->controller->createForm(
            $this->getFormType(),
            $this->getEntity($id),
            $config + [
                'action' => $this->getRoute($route, $id ? ['id' => $id] : array()),
                'method' => $method,
            ]
        );
    }

    public function getFormType()
    {
        return $this->formType;
    }

    /**
     * @param string|AbstractType|null $formType
     * @return $this
     * @throws \Exception
     */
    public function setFormType($formType = null)
    {
        $is = is_subclass_of($formType, 'Symfony\Component\Form\AbstractType');
        if (is_object($formType) && $is) {
            $this->formType = $formType;

        } elseif (class_exists($formType)) {
            $this->formType = new $formType();

        } elseif (!is_null($formType)) {
            //Todo : Create an specific exception
            throw new \Exception('The form type is not a valid objet !');
        }

        return $this;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @return ObjectRepository
     */
    public function getEntityRepository()
    {
        return $this->entityRepository;
    }

} 