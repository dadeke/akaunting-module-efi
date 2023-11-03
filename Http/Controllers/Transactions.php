<?php

namespace Modules\Efi\Http\Controllers;

use App\Abstracts\Http\Controller;
use App\Traits\DateTime as TraitDateTime;
use Modules\Efi\Models\Transaction;
use Modules\Efi\Traits\Efi;

class Transactions extends Controller
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
        $emptyPageButtons = [
            [
                'url' => route('invoices.create'),
                'permission' => 'create-sales-invoices',
                'text' => trans(
                    'general.title.new',
                    ['type' => trans('efi::general.create_name')]
                ),
                'description' => trans(
                    'general.empty.actions.new',
                    ['type' => trans('efi::general.create_name')]
                ),
                'active_badge' => true
            ]
        ];

        $statuses = [
            'draft',
            'sent',
            'viewed',
            'partial',
            'paid'
        ];

        $transactions = Transaction::select(
                'id',
                'document_id'
            )
            ->whereHas('document',
                fn($query) => $query->select('id')
                    ->whereIn('status', $statuses)
            )
            ->collect(['document.issued_at' => 'desc']);

        // Eager loading
        $transactions->load(
            'document.contact',
            'document.items',
            'document.transactions'
        );

        return $this->response('efi::admin.index', [
            'records' => $transactions,
            'tabActive' => 'transactions',
            'withoutTabs' => ! setting('efi.logs') == '1',
            'emptyPageButtons' => $emptyPageButtons,
            'certExpiry' => $this->getCertExpiry()
        ]);
    }
}
