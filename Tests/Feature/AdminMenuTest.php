<?php

namespace Modules\Efi\Tests\Feature;

use App\Traits\Permissions;
use Tests\Feature\FeatureTestCase;

class AdminMenuTest extends FeatureTestCase
{
    use Permissions;

    public function testItShouldSeeAdminTransactionsMenuItem()
    {
        $this->loginAs()
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee(route('efi.transactions.index'))
            ->assertSee(trans('efi::general.transactions'));
    }

    public function testItShouldNotSeeAdminTransactionsMenuItem()
    {
        $this->detachPermissionsFromAdminRoles([
            'sales-invoices' => 'r',
        ]);

        $this->loginAs()
            ->get(route('dashboard'))
            ->assertOk()
            ->assertDontSee(
                '<a id="menu-efi-transactions" class="flex items-center text-purple" href="'
                . route('efi.transactions.index') . '" >',
                false
            );
    }
}
