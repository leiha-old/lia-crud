<?php

namespace Lia\CrudBundle\Action;

use Symfony\Component\HttpFoundation\Request;

class IndexAction
    extends ActionBase

{
    public function createForm($id = null){}

    public function execute(Request $request, $id = null){}

    public function display(Request $request = null, $id = null)
    {
        $entities = $this->config->getEntityRepository()->findAll();
        return [
            'entities'     => $entities,
            'configurator' => $this->config,
        ];
    }
}