<?php

namespace App\Listeners\Users\Notifications;

use App\Events\Users\UpdatedUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyUpdatedUser
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
     * @param  UpdatedUser  $event
     * @return void
     */
    public function handle(UpdatedUser $event)
    {
        //
    }
}
