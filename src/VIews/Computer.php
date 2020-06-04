<?php

namespace SiObjects\Entitys\Views;

use Tramite\Contracts\Action\Component;

/**
 * User Helper - Provides access to logged in user information in views.
 *
 * @author Ricardo Sierra <ricardo@sierratecnologia.com>
 */
class Computer
{

    protected $target = false;

    public function __construct(Component $target)
    {
        $this->target = $target;
    }

    public function getComponents()
    {
        return [
            'url' => $this->target->getActualLocale(),
            'status' => $this->target()
        ];
    }
    
    
    public function getActions()
    {
        return [

        ];
    }
}
?>