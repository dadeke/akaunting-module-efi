<?php

namespace Modules\Efi\Providers;

use Illuminate\Support\ServiceProvider as Provider;
use App\Models\Document\Document;

class Observer extends Provider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        Document::observe('Modules\Efi\Observers\Document');
    }
}
