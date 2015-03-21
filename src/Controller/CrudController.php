<?php

namespace Lia\CrudBundle\Controller;


use Lia\KernelBundle\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class CrudController
 * @package Lia\CrudBundle\Controller
 *
 */
abstract class CrudController
    extends ControllerBase
    implements CrudControllerInterface
{
    /**
     * Lists all Entities.
     *
     * @Template()
     */
    public function indexAction()
    {
        return $this->getCrud('index')->display();
    }

    /**
     * Finds and displays a User entity.
     *
     * @Template()
     * @param Request $request  Current Request
     * @param int     $id       Id of entity
     * @return
     */
    public function showAction(Request $request, $id)
    {
        return $this->getCrud('show')->display($request, $id);
    }

    /**
     * Creates a new User entity
     * + Displays a form.
     *
     * @Template()
     * @param Request $request  Current Request
     */
    public function createAction(Request $request)
    {
        $method = 'POST' == $request->getMethod()
            ? 'execute'
            : 'display'
            ;

        return $this->getCrud('create')->$method($request);
    }

    /**
     * Edits an existing User entity.
     * + Displays a form.
     *
     * @Template()
     * @param Request $request  Current Request
     * @param int     $id       Id of entity
     */
    public function editAction(Request $request, $id)
    {
        $method = 'PUT' == $request->getMethod()
            ? 'execute'
            : 'display'
        ;

        return $this->getCrud('edit')->$method($request, $id);
    }

    /**
     * Deletes a User entity.
     * @param Request $request  Current Request
     * @param int     $id       Id of entity
     *
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->getCrud('delete')->execute($request, $id);
    }
} 