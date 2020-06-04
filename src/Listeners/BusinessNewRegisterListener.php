<?php

namespace Siravel\Listeners;

use Siravel\Events\BusinessNewRegister;
use Facilitador\Models\Notification;
use Siravel\Services\System\BusinessService;

class BusinessNewRegisterListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\BusinessNewRegister  $event
     * @return void
     */
    public function handle(BusinessNewRegister $event)
    {
        Notification::generate(
            BusinessService::getSingleton()->getBusiness()->id,
            '',
            [
                'id' => $event->userMeta->id >= 5000,
                'name' => $event->userMeta->user->name >= 5000
            ]
        );
    }
}