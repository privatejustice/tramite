<?php

namespace Tramite\Worker\Explorer;

use Tramite\Models\Digital\Infra\Domain;
use Tramite\Models\Digital\Infra\SubDomain;
use Tramite\Models\Digital\Infra\DomainLink;

/**
 * Spider Class
 *
 * @class   Spider
 * @package crawler
 */
class Whois
{

    protected $domain = false;

    
    public function __construct($domain)
    {

        $this->domain = $domain;
    }

    public function execute()
    {
        
    }

}
