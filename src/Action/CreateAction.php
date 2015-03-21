<?php

namespace Lia\CrudBundle\Action;

use Symfony\Component\HttpFoundation\Request;

class CreateAction
    extends ActionBase
{
    /**
     * Creates a form to create a User entity.
     *
     * @param null $id
     * @return \Symfony\Component\Form\Form The form
     */
    public function createForm($id=null)
    {
        return $this->config->getEntityForm('create', $id)
            ->add('submit', 'submit', ['label' => 'Create'])
            ;
    }

    public function display(Request $request=null, $id=null){
        return [
            'entity'       => $this->config->getEntity(),
            'create_form'  => $this->createForm($id)->createView(),
            'configurator' => $this->config,
        ];
    }

    /**
     * Creates a new User entity.
     *
     * @param Request $request
     * @param int $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute(Request $request, $id=null)
    {
        $entity = $this->config->getEntity();
        $form   = $this->createForm($entity)->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->config->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->config->controller->redirect(
                $this->config->getRoute('create', ['id' => $entity->getId()])
            );
        }

        return $this->display($request);
    }


} 