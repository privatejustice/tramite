<?php
/**
 * 
 */

namespace SiObjects\Entitys\Views;

use Log;
use SiUtils\Tools\Software\FilePrograms;

class File extends Board
{

    public function editAction()
    {
        
    }

    public function showAction()
    {
        
    }

    /**
     * 
     */
    protected function dashboard()
    {

    }

    protected function getInteresses()
    {
        return [

        ];
    }

    /**
     * 
     */
    public function getPrograms()
    {

        return [
            FilePrograms::class
        ];
    }

}
