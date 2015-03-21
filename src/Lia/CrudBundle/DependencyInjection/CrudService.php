<?php

namespace Lia\CrudBundle\DependencyInjection;

use Lia\KernelBundle\Service\ServiceBase;
use Lia\CrudBundle\Action\ActionInterface;
use Lia\CrudBundle\Action\CreateAction;
use Lia\CrudBundle\Action\DeleteAction;
use Lia\CrudBundle\Action\EditAction;
use Lia\CrudBundle\Action\IndexAction;
use Lia\CrudBundle\Action\ShowAction;
use Lia\CrudBundle\Controller\CrudController;


class CrudService
    extends ServiceBase
{
    /**
     * @param CrudController $controller
     * @return ActionInterface|IndexAction
     */
    public function index(CrudController $controller)
    {
        return $this->createAction('index', $controller);
    }

    /**
     * @param CrudController $controller
     * @return ActionInterface|EditAction
     */
    public function edit(CrudController $controller)
    {
        return $this->createAction('edit', $controller);
    }

    /**
     * @param CrudController $controller
     * @return ActionInterface|ShowAction
     */
    public function show(CrudController $controller)
    {
        return $this->createAction('show', $controller);
    }

    /**
     * @param CrudController $controller
     * @return ActionInterface|CreateAction
     */
    public function create(CrudController $controller)
    {
        return $this->createAction('create', $controller);
    }

    /**
     * @param CrudController $controller
     * @return ActionInterface|DeleteAction
     */
    public function delete(CrudController $controller)
    {
        return $this->createAction('delete', $controller);
    }

    /**
     * @param string $actionName
     * @param CrudController  $controller
     * @return ActionInterface
     */
    protected function createAction($actionName, CrudController $controller)
    {
        //TODO: Maybe Checking if file exist
        $objectName = 'Lia\CrudBundle\Action\\'.ucfirst($actionName).'Action';
        return new $objectName(
            new CrudServiceConfiguration($controller)
        );
    }
}
