<x-layouts.admin>
    <x-slot name="title">
        {{ trans('efi::general.transactions') }}
    </x-slot>

    <x-slot name="favorite"
        title="{{ trans('efi::general.transactions') }}"
        icon="description"
        route="efi.transactions.index"
    ></x-slot>

    <x-slot name="content">
        @if ($certExpiry != null)
        <div @class(['rounded-xl px-5 py-3 my-5', "bg-{$certExpiry['color']}-100"])>
            <p @class(['text-sm mb-0', "text-{$certExpiry['color']}-600"])>
                {!! html_entity_decode($certExpiry['message']) !!}
            </p>
        </div>
        @endif

        @if (! $withoutTabs || $tabActive != 'transactions')
            <x-index.container>
                <x-tabs active="{{ $tabActive }}">
                    <x-slot name="navs">
                        @stack('transaction_nav_start')

                        @if ($tabActive == 'transactions')
                            <x-tabs.nav
                                id="transactions"
                                name="{{ trans('efi::general.transactions_tab') }}"
                                active
                            />
                        @else
                            <x-tabs.nav-link
                                id="transactions"
                                name="{{ trans('efi::general.transactions_tab') }}"
                                href="{{ route('efi.transactions.index') }}"
                            />
                        @endif

                        @stack('transaction_nav_end')

                        @stack('log_nav_start')

                        @if ($tabActive == 'logs')
                            <x-tabs.nav
                                id="logs"
                                name="{{ trans('efi::general.logs_tab') }}"
                                active
                            />
                        @else
                            <x-tabs.nav-link
                                id="logs"
                                name="{{ trans('efi::general.logs_tab') }}"
                                href="{{ route('efi.logs.index') }}"
                            />
                        @endif

                        @stack('log_nav_end')
                    </x-slot>

                    <x-slot name="content">
                        @if ($records->count() || request()->get('search', false))
                            {{-- It doesn't work. Fix in future --}}
                            {{-- <x-index.search
                                search-string="Modules\Efi\Models\Transaction"
                                route="efi.transactions.index"
                            /> --}}

                            @stack('transaction_tab_start')

                            @if ($tabActive == 'transactions')
                                <x-tabs.tab id="transactions">
                                    @include('efi::admin.transaction', ['transactions' => $records])
                                </x-tabs.tab>
                            @endif

                            @stack('transaction_tab_end')

                            @stack('log_tab_start')

                            @if ($tabActive == 'logs')
                                <x-tabs.tab id="logs">
                                    @include('efi::admin.log', ['logs' => $records])
                                </x-tabs.tab>
                            @endif

                            @stack('log_tab_end')
                        @else
                            <div class="flex flex-col lg:flex-row">
                                <div class="w-full lg:w-1/2">
                                    <div class="border-b px-2 pb-3">
                                        <p class="mt-6 text-sm">
                                            {!! trans('efi::general.empty.' . $tabActive) !!}
                                        </p>
                                    </div>
                                </div>

                                <div class="w-full lg:w-1/2 flex justify-end mt-8 lg:mt-20">
                                    <img
                                        src="public/img/empty_pages/invoices.png"
                                        alt="{{ trans('efi::general.name') }}"
                                    />
                                </div>
                            </div>
                        @endif
                    </x-slot>
                </x-tabs>
            </x-index.container>
        @else
            @if ($records->count() || request()->get('search', false))
                <x-index.container>
                    {{-- It doesn't work. Fix in future --}}
                    {{-- <x-index.search
                        search-string="Modules\Efi\Models\Transaction"
                        route="efi.transactions.index"
                    /> --}}

                    @stack('transaction_start')

                    @include('efi::admin.transaction', ['transactions' => $records])

                    @stack('transaction_end')
                </x-index.container>
            @else
                <x-empty-page
                    group="efi"
                    page="transactions"
                    image-empty-page="public/img/empty_pages/invoices.png"
                    text-empty-page="efi::general.empty.transactions"
                    docs-category="payment-method"
                    url-docs-path="#"
                    :buttons="$emptyPageButtons"
                    check-permission-create="true"
                />
            @endif
        @endif
    </x-slot>

    <x-documents.script type="invoice" />
</x-layouts.admin>
