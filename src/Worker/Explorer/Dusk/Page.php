<?php

namespace Tramite\Worker\Explorer\Dusk;

use Laravel\Dusk\Page as BasePage;

class Page extends BasePage
{

    public function url()
    {

    }
    
    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    public static function siteElements()
    {
        return [
            '@element' => '#selector',
        ];
    }
}