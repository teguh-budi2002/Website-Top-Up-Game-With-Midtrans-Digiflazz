@extends('dashboard.layouts.app_dashboard')
@section('header')
Manage Marketplace Provider
@endsection
@section('dashboard_main')
<main class="w-full h-full overflow-x-hidden">
    @if ($mess = Session::get('provider'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-white text-center bg-green-300">{{ $mess }}</div>
    </div>
    @elseif ($mess = Session::get('provider-failed'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-red-500 text-center bg-red-300">{{ $mess }}</div>
    </div>
    @endif
    @if ($errors->any())
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-red-500 text-center bg-red-300">{{ $errors->first() }}</div>
    </div>
    @endif
    <div class="w-full h-full">
        <div class="w-full h-full flex justify-center">
            <div class="w-full h-fit grid md:grid-cols-2 grid-cols-1 gap-2 md:mx-16 mx-3">
                <div class="w-full h-auto rounded bg-white shadow-md p-4 mt-5 mb-5">
                    @include('dashboard.views.manage_provider.custom_provider')
                </div>
                <div class="w-full h-fit mt-5">
                    <div class="list_page w-full h-fit rounded bg-white shadow-md p-4">
                        <div class="mt-2 mb-2 flex justify-end items-center">
                            <button data-popover-target="popover-bottom-warning-pg" data-popover-placement="top" type="button"
                                class="text-sm p-2 bg-rose-600 text-white rounded-md">WARNING!</button>
                            <div data-popover id="popover-bottom-warning-pg" role="tooltip"
                                class="absolute z-10 invisible inline-block w-64 transition-opacity duration-300 bg-rose-100 rounded-lg shadow-sm opacity-0">
                                <div class="px-3 py-2">
                                    <p class="text-rose-500 text-sm">If you deactivate a provider, all payment settings will be cleared, and will revert to the original settings.</p>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                        </div>
                        <div class="overflow-x-auto p-3">
                            <table class="w-full">
                                <thead
                                    class="text-xs font-semibold uppercase text-white dark:text-light bg-primary hover:bg-primary-dark">
                                    <tr>
                                        <th></th>
                                        <th class="p-2">
                                            <div class="font-semibold text-left">Provider Name</div>
                                        </th>
                                        <th class="p-2">
                                            <div class="font-semibold text-left">Username Provider</div>
                                        </th>
                                        <th class="p-2">
                                            <div class="font-semibold text-left">Provider Key</div>
                                        </th>
                                        <th class="p-2">
                                            <div class="font-semibold text-left">Status</div>
                                        </th>
                                        <th class="p-2">
                                            <div class="font-semibold text-left">Action</div>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="text-sm text-primary dark:text-primary-light divide-y divide-primary-100">
                                    @if (count($providers))
                                    @foreach ($providers as $provider)
                                    <tr id="{{ $provider->id }}">
                                        <td class="p-2">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="p-2">
                                            <p>{{ Str::ucfirst($provider->provider_name) }}</p>
                                        </td>
                                        <td class="p-2">
                                            <p>{{ $provider->username }}</p>
                                        </td>
                                        <td class="p-2">
                                            <p>{{ $provider->key }}</p>
                                        </td>
                                        <td class="p-2">
                                            <button
                                                class="{{ $provider->status ? 'bg-green-400' : 'bg-rose-400' }} text-white rounded p-1 px-2">{{ $provider->status ? 'Active' : 'Inactive' }}</button>
                                        </td>
                                        <td class="p-2 flex justify-start items-center space-x-2 mt-1.5">
                                            <a href="?provider_name={{ $provider->provider_name }}"
                                                class="block p-1 bg-primary-100 rounded hover:bg-primary hover:text-white transition-colors duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </a>
                                            @if ($provider->status)
                                            <form
                                                action="{{ URL("dashboard/settings/provider/deactive-provider/" . $provider->id) }}"
                                                method="POST">
                                                @csrf
                                                <button data-popover-target="popover-bottom-deactive"
                                                    data-popover-placement="bottom" type="submit"
                                                    class="bg-rose-400 p-1 rounded text-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                                                    </svg>
                                                </button>
                                                <div data-popover id="popover-bottom-deactive" role="tooltip"
                                                    class="absolute z-10 invisible inline-block w-fit text-xs text-white transition-opacity duration-300 bg-rose-400 rounded shadow-sm opacity-0">
                                                    <div class="px-2 py-1">
                                                        <p>Deactive Now</p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </form>
                                            @else
                                            <form
                                                action="{{ URL("dashboard/settings/provider/activated-provider/" . $provider->id) }}"
                                                method="POST">
                                                @csrf
                                                <button data-popover-target="popover-bottom-active"
                                                    data-popover-placement="bottom" type="submit"
                                                    class="bg-green-400 p-1 rounded text-white">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                                                    </svg>
                                                </button>
                                                <div data-popover id="popover-bottom-active" role="tooltip"
                                                    class="absolute z-10 invisible inline-block w-fit text-xs text-white transition-opacity duration-300 bg-green-400 rounded shadow-sm opacity-0">
                                                    <div class="px-2 py-1">
                                                        <p>Activated Now</p>
                                                    </div>
                                                    <div data-popper-arrow></div>
                                                </div>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <div class="text-center mb-3">
                                        <p class="capitalize text-xl">Please setting your payment gateway</p>
                                    </div>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="mb-2 p-4">
                        {{ $providers->links('vendor.pagination.simple-tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
