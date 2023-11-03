<?php

namespace Modules\Efi\Listeners;

use App\Events\Module\PaymentMethodShowing as Event;

class ShowAsPaymentMethod
{
    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        $method = setting('efi');

        $method['code'] = 'efi';

        $event->modules->payment_methods[] = $method;
    }
}
