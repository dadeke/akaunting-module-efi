<?php

namespace Modules\Efi\Http\Controllers;

use App\Http\Controllers\Settings\Modules;
use App\Http\Requests\Setting\Module as Request;
use App\Models\Banking\Account;
use App\Models\Setting\Setting;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log as FacadeLog;
use Modules\Efi\Models\Log;
use Modules\Efi\Traits\Efi;

class Settings extends Modules
{
    use Efi;

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit($alias)
    {
        $accounts = Account::enabled()->orderBy('name')->pluck('name', 'id');

        $setting = Setting::prefix($alias)->get()->transform(function ($s)
				use ($alias) {
            $s->key = str_replace($alias . '.', '', $s->key);
            return $s;
        })->pluck('value', 'key');

        $module = module($alias);
        $fields = $module->get('settings');

        // Translate values from selectGroup named "mode"
        $translated_values = array();
        $index_key = array_search('mode', array_column($fields, 'name'));
        foreach($fields[$index_key]['values'] as $key => $value) {
            $translated_values[$key] = trans($value);
        }
        $fields[$index_key]['values'] = $translated_values;

        return view(
            'efi::settings.edit',
            compact('setting', 'module', 'accounts', 'fields')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function update($alias, Request $request)
    {
        $setting = setting();
        $logs_before = $setting->get('efi.logs');

        $response = parent::update($alias, $request);

        if(($logs_before == null || $logs_before == '0') && $request['logs'] == '1') {
            $data = [
                'company_id' => company_id(),
                'error' => false,
                'action' => 'enable',
                'message' => 'Logs enabled.'
            ];

            Log::create($data);
        }
        else if($logs_before == '1' && $request['logs'] == '0') {
            $data = [
                'company_id' => company_id(),
                'error' => false,
                'action' => 'disable',
                'message' => 'Logs disabled.'
            ];

            Log::create($data);
        }

        try {
            $this->pixConfigWebhook();

            $certificate = openssl_x509_parse($request['pix_cert']);
            $setting->set(
                'efi.cert_timestamp',
                $certificate['validTo_time_t']
            );
            $setting->save();
        }
        catch(\Exception $e) {
            $message = null;

            if(
                property_exists($e, 'error') &&
                property_exists($e, 'errorDescription')
            ) {
                $message = $e->error . ' '
                    . json_encode($e->errorDescription, JSON_UNESCAPED_UNICODE);
            }
            else {
                $message = $e->getMessage();
            }

            if($request['logs'] == '1') {
                Log::create([
                    'company_id' => company_id(),
                    'action' => 'webhook',
                    'error' => true,
                    'message' => $message
                ]);
            }
            else {
                FacadeLog::error('module=Efi'
                    . ' action=Webhook'
                    . ' message=' . $message
                );
            }
        }

        return $response;
    }
}
