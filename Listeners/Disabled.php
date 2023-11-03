<?php

namespace Modules\Efi\Listeners;

use App\Events\Module\Disabled as Event;

class Disabled
{
    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        // Check if it is not this module
        if($event->alias != 'efi') {
            return;
        }

        $listenUninstalled = new Uninstalled();
        $listenUninstalled->execute($event->company_id);
    }
}
