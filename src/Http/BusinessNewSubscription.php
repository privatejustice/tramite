<?php

namespace Siravel\Events;

use Siravel\Models\Negocios\Subscription;
use Illuminate\Queue\SerializesModels;

class BusinessNewSubscription
{
    use SerializesModels;

    public $subscription;

    /**
     * Create a new event instance.
     *
     * @param  \Siravel\Models\Negocios\Subscription  $subscription
     * @return void
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }
}