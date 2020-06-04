<?php

namespace Tramite\Processing;

use Log;
use App\Models\User;

class CalculeMetrics
{
    
    public function __construct()
    {
        
    }

    public function run()
    {
        $this->byPeriod();
    }

    public function byPeriod()
    {
        $this->forIntegrations();
    }
    
    public function forIntegrations()
    {
        $selfClass = $this;
        $this->board->executeForEachIntegration(
            function ($integration) use ($selfClass) {
                $selfClass->forComponents($integration);
            }
        );
    }
    
    public function forComponents($integration)
    {
        $selfClass = $this;
        $this->board->executeForEachComponent(
            function ($component, $callback) use ($integration) {
                $data = $integration->getNewDataForComponent($component);
                foreach($data as $result) {
                    $callback($result);
                }
            }
        );
    }

}
