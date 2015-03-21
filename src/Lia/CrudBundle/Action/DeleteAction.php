<?php

namespace Lia\CrudBundle\Action;

use Symfony\Component\HttpFoundation\Request;

class DeleteAction
    extends ActionBase
{

    public function display(Request $request=null, $id=null){}

    /**
     * Delete an entity.
     * @param Request $request
     * @param int|null $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute(Request $request=null, $id=null)
    {
        $form = $this->createForm($id);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->config->getEntityManager();
            $em->remove($this->config->getEntity($id));
            $em->flush();
        }
        return $this->config->controller->redirect($this->config->getRoute('index'));
    }

    /**
     * Creates a form with alone button to launch the delete action for an entity.
     *
     * @param int|null $id
     * @return \Symfony\Component\Form\Form The form
     */
    public function createForm($id=null)
    {
        return $this->config->controller->createFormBuilder()
            ->setAction($this->config->getRoute('delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
            ;
    }
}