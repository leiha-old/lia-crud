<?php

namespace Lia\CrudBundle\Controller;


use Lia\CrudBundle\DependencyInjection\CrudServiceConfiguration;

interface CrudControllerInterface {

    public function setConfiguration(CrudServiceConfiguration $config);

}