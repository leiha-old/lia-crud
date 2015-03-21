<?php

namespace Lia\CrudBundle\Action;

use Symfony\Component\HttpFoundation\Request;

class ShowAction
    extends ActionBase

{
    public function createForm($id = null){}

    public function execute(Request $request, $id = null){}

    public function display(Request $request = null, $id = null)
    {
        return [
            'entity'      => $this->config->getEntity($id),
            'delete_form' => $this->createDeleteForm($id)->createView(),
            'configurator'=> $this->config,
        ];
    }

    /**
     * @param $id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id){
        return $this->config->controller->getCrud('delete')->createForm($id);
    }
}