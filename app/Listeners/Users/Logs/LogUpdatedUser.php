<?php

namespace App\Listeners\Users\Logs;

use App\Models\UserLog;
use App\Events\Users\UpdatedUser;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogUpdatedUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  UpdatedUser  $event
     * @return void
     */
    public function handle(UpdatedUser $event)
    {
        UserLog::create([
            'user_id' => $event->user->id,
            'slug' => 'updated_user',
            'message' => "{$event->user->name}'s profile has been updated by: " . ($event->updated_by->name ?? "Not Found") . "on {$event->updated_at}",
            'metadata' => ['user' => $event->user, 'updated_by' => $event->updated_by, 'updated_at' => $event->updated_at ]

        ]);
        return true;
    }
}
