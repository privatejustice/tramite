<?php

namespace Tramite\Listeners;

use Siravel\Events\BusinessNewRegister;
use Facilitador\Models\Notification;
use Siravel\Services\BusinessService;

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
     *
     * @return void
     */
    public function subscribe($events): void
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
     * @param BusinessNewRegister $event
     *
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
     * @param OrderShipped $event
     * @param \Exception               $exception
     *
     * @return void
     */
    public function failed(OrderShipped $event, $exception)
    {
        //
    }
}