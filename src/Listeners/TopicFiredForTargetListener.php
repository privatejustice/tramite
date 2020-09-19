<?php

namespace Tramite\Listeners;

use Tramite\Events\BusinessNewRegister;
use Facilitador\Models\Notification;
use Tramite\Services\System\BusinessService;

class TopicFiredForTargetListener
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
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@handleUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@handleUserLogout'
        );
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\BusinessNewRegister $event
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
        Notification::send($event->user, new NewAccountEmail($event->password));
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\OrderShipped $event
     * @param  \Exception               $exception
     * @return void
     */
    public function failed(OrderShipped $event, $exception)
    {
        //
    }
}