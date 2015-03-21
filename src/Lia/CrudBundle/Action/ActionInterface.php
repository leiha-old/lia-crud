<?php

namespace Lia\CrudBundle\Action;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface ActionInterface
 * @package Lia\CrudBundle\Action
 */
interface ActionInterface
{
    /**
     * @param int|null $id
     * @return \Symfony\Component\Form\Form The form
     */
    public function createForm($id = null);

    /**
     * @param Request $request
     * @param int|null $id
     * @return mixed
     */
    public function execute(Request $request, $id = null);

    /**
     * @param Request $request
     * @param int|null $id
     * @return mixed
     */
    public function display(Request $request = null, $id = null);
} 