<?php

namespace Modules\Efi\Listeners;

use App\Events\Menu\AdminCreated as Event;
use App\Traits\Modules;

class AddToAdminMenu
{
    use Modules;

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if($this->moduleIsDisabled('efi') || user()->cannot('read-sales-invoices')) {
            return;
        }

        $item = $event->menu->whereTitle(trans_choice('general.sales', 2));
        $item->route(
            'efi.transactions.index',
            trans('efi::general.transactions'),
            [],
            12,
            ['icon' => '']
        );
    }
}
