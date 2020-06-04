<?php

namespace Siravel\Events;

use Facilitador\Models\UserMeta;
use Illuminate\Queue\SerializesModels;

class BusinessNewRegister
{
    use SerializesModels;

    public $subscription;

    /**
     * Create a new event instance.
     *
     * @param  \Facilitador\Models\UserMeta  $subscription
     * @return void
     */
    public function __construct(UserMeta $subscription)
    {
        $this->subscription = $subscription;
    }
}