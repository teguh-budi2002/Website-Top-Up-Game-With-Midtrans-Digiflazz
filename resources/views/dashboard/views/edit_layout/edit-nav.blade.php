@extends('dashboard.layouts.app_dashboard')
@section('dashboard_main')
<main class="w-full h-screen">
  @if ($mess = Session::get('edit_nav_layout_success'))
  <div class="mx-16 mt-4">
    <div class="p-2 rounded text-white text-center bg-green-300">{{ $mess }}</div>
  </div>
  @endif
    <div class="w-3/4 bg-white rounded p-5 mx-auto mt-8">
      <div class="accordion_layout">
        <div id="accordion-collapse" data-accordion="collapse">
            <div id="accordion-collapse-heading-1">
                <button type="button"
                    class="flex items-center justify-between w-full p-4 font-medium text-left  border border-b-0 dark:border-gray-700  dark:bg-gray-700 rounded-t"
                    data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
                    aria-controls="accordion-collapse-body-1">
                    <span class="text-gray-500 dark:text-gray-400 dark:hover:text-white">Text Head Navigation</span>
                    <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
                <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-600">
                    <p class="mb-2 text-gray-500 dark:text-gray-200">Example</p>
                    <img src="{{ asset("/img/ExampleLayout/TextHeaderNavigation.webp") }}" class="w-auto h-20 rounded-md" alt="Contoh Text Head Nav">
                    <form action="{{ URL("dashboard/layout/nav/edit") }}" method="POST" class="mt-3">
                      @csrf
                      <div class="form_group">
                         <x-form.input type="text" inputName="text_head_nav" name="text_head_nav"
                        label="Masukkan Text Pada Header Navigation" />
                        @error('text_head_nav')
                            <p class="text-xs text-rose-500 capitalize mt-1">{{ $message }}</p>
                        @enderror
                      </div>
                      <div class="btn_submit mt-3">
                        <button class="py-2.5 px-6 rounded bg-primary text-white">Edit Layout</button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
