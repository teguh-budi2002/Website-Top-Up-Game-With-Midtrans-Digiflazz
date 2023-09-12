@extends('dashboard.layouts.app_dashboard')
@section('header')
Manage Navigation Layout
@endsection
@section('dashboard_main')
<main class="w-full h-full">
    @if ($mess = Session::get('edit_nav_layout_success'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-white text-center bg-green-300">{{ $mess }}</div>
    </div>
    @endif
    <div class="w-11/12 bg-white rounded p-5 mx-auto mt-8">
        <div class="p-5 dark:border-gray-700 dark:bg-primary-100 bg-primary-50">
            <p class="mb-2 text-gray-500 dark:text-gray-200">Example</p>
            <img src="{{ asset("/img/ExampleLayout/TextHeaderNavigation.webp") }}" class="w-auto h-20 rounded-md"
                alt="Contoh Text Head Nav">
            <form action="{{ URL("dashboard/layout/nav/edit") }}" method="POST" class="mt-3">
                @csrf
                <div class="form_group">
                    <x-form.input type="text" inputName="text_head_nav" name="text_head_nav"
                        label="Add Slogan Into your Navigation" />
                    @error('text_head_nav')
                    <p class="text-xs text-rose-500 capitalize mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="btn__submit mt-3 flex items-center space-x-2">
                    <button class="py-2.5 px-6 rounded bg-primary text-white">Edit Layout</button>
                    <button data-tooltip-target="tooltip-banner-layout" data-tooltip-style="light" type="button"
                        class="text-white bg-primary rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                        </svg>
                    </button>
                    <div id="tooltip-banner-layout" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 tooltip">
                        <span>When the admin edits the layout, the previous layout is automatically deleted.</span>
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
