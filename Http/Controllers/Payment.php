<?php

namespace Modules\Efi\Http\Controllers;

use App\Abstracts\Http\PaymentController;
use App\Http\Requests\Portal\InvoicePayment as PaymentRequest;
use App\Models\Document\Document;
use Illuminate\Support\Facades\Log as FacadeLog;
use Modules\Efi\Models\Log;
use Modules\Efi\Models\Transaction;
use Modules\Efi\Traits\Efi;

class Payment extends PaymentController
{
    use Efi;

    public $alias = 'efi';

    public $type = 'redirect';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function show(Document $invoice, PaymentRequest $request, $cards = [])
    {
        $html = null;
        $setting = $this->setting;

        $transaction = Transaction::where('document_id', $invoice->id)->first();
        if($transaction !== null) {
            $payment = [];

            try {
                $payment = $this->pixGenerateQRCode($transaction->location_id);

                $html = view('efi::portal.show', compact('setting', 'payment'))
                            ->render();
            }
            catch(\Exception $e) {
                if($this->setting['logs'] == '1') {
                    Log::create([
                        'company_id' => company_id(),
                        'document_id' => $invoice->id,
                        'action' => 'show',
                        'error' => true,
                        'message' => $e->getMessage()
                    ]);
                }
                else {
                    FacadeLog::error('module=Efi'
                        . ' action=Show'
                        . ' document_id=' . $invoice->id
                        . ' txid=' . $transaction->txid
                        . ' message=' . $e->getMessage()
                    );
                }

                $html = view('efi::portal.unavailable')->render();
            }
        }
        else {
            $html = view('efi::portal.unavailable')->render();
        }

        return response()->json([
            'name' => $setting['name'],
            'description' => $setting['description'],
            'redirect' => false,
            'html' => $html
        ]);
    }
}
