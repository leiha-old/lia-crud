<?php

namespace Lia\CrudBundle\Action;

use Symfony\Component\HttpFoundation\Request;

class EditAction
    extends ActionBase
{

    protected $entityItem;

    public function display(Request $request=null, $id=null){
        return [
            'entity'      => $this->config->getEntity($id),
            'delete_form' => $this->createDeleteForm($id)->createView(),
            'edit_form'   => $this->createForm($id)->createView(),
            'configurator'=> $this->config,
        ];
    }

    /**
     * Creates a new User entity.
     *
     * @param Request $request
     * @param null $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute(Request $request, $id=null)
    {
        $entityItem = $this->config->getEntity($id);
        $editForm   = $this->createForm($entityItem->getId())->handleRequest($request);
        if ($editForm->isValid()) {
            $this->config->getEntityManager()->flush();
            return $this->config->controller->redirect(
                $this->config->getRoute('show', ['id' => $id])
            );
        }

        return $this->display($request, $entityItem);
    }

    /**
     * Creates a form to update an entity.
     *
     * @param int|null $id
     * @return \Symfony\Component\Form\Form The form
     */
    public function createForm($id=null)
    {
        return $this->config->getEntityForm('edit', $id, 'PUT')
            ->add('submit', 'submit', ['label' => 'Update'])
            ;
    }

    /**
     * @param $id
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id){
        return $this->config->controller->getCrud('delete')->createForm($id);
    }
} 