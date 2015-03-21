<?php

namespace Lia\CrudBundle\Action;

use Lia\CrudBundle\DependencyInjection\CrudServiceConfiguration;

abstract class ActionBase
    implements ActionInterface
{
    /**
     * @var CrudServiceConfiguration
     */
    public $config;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    protected $dispatcher;

    public function __construct(CrudServiceConfiguration $config){
        $this->config     = $config;
        $this->dispatcher = $this->config->controller->get('event_dispatcher');
    }
}