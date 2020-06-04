<?php

namespace Tramite\Instagram;

use Illuminate\Support\Facades\Facade;

class Instagram
{
    protected $targets = [];
    protected $executor = false;
    protected $account = false;
    protected $userName = false;
    public function __construct($instagram, $cache = false)
    {
        $this->account = $instagram;
        $this->userName = $this->account->getUser();
        // dd($instagram, $this->userName, $this->account->getPassword());
        ($this->executor = \InstagramScraper\Instagram::withCredentials(
            $this->userName, $this->account->getPassword(), $this->getCache($cache)
        ))->login();
    }

    public function getSlug()
    {
        return $this->userName;
    }

    public function prepare($targets)
    {
        if (is_string($targets)) {
            $this->targets = [$targets];
            return $this;
        }
        $this->targets = $targets;
        return $this;
    }

    private function getCache($cache)
    {

        if (!$cache) {
            return '';
        }
        
        return $cache;
    }

    public function execute()
    {
        collect($this->targets)->each(
            function ($target) {
                $this->executeForEach($target);
            }
        );

        return $this;
    }
}
