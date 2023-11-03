<?php

namespace Modules\Efi\Http\Controllers;

use App\Abstracts\Http\Controller;
use App\Traits\DateTime as TraitDateTime;
use Modules\Efi\Models\Log;
use Modules\Efi\Traits\Efi;

class Logs extends Controller
{
    use TraitDateTime, Efi;

    public function __construct()
    {
        // This is to clear the middlewares.
    }

    /**
     * Index
     */
    public function index()
    {
        $logs = Log::select(
                'id',
                'action',
                'error',
                'message',
                'created_at'
            )
            ->collect(['created_at' => 'desc']);

        $datetime_format = $this->getCompanyDateFormat() . ' ' . 'H:i:s';

        return $this->response('efi::admin.index', [
            'records' => $logs,
            'tabActive' => 'logs',
            'withoutTabs' => ! setting('efi.logs') == '1',
            'datetime_format' => $datetime_format,
            'certExpiry' => $this->getCertExpiry()
        ]);
    }
}
