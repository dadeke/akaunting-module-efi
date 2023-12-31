<?php

namespace Modules\Efi\Tests\Feature;

use Tests\Feature\FeatureTestCase;

class LogTest extends FeatureTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $setting = setting();
        $setting->setExtraColumns(['company_id' => $this->company->id]);
        $setting->set('efi', ['logs' => '1']);
        $setting->save();
    }

    public function testItShouldSeeTitle()
    {
        $this->loginAs()
            ->get(route('efi.logs.index'))
            ->assertStatus(200)
            ->assertSeeText(trans('efi::general.transactions'));
    }

    public function testItShouldSeeLogTab()
    {
        $this->loginAs()
            ->get(route('efi.logs.index'))
            ->assertStatus(200)
            ->assertSee('tab-logs');
    }
}
