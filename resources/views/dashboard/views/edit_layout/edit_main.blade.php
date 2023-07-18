@extends('dashboard.layouts.app_dashboard')
@section('dashboard_main')
<main class="w-full h-auto">
    @if ($mess = Session::get('edit_banner_layout_success'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-white text-center bg-green-300">{{ $mess }}</div>
    </div>
    @endif
    <div class="w-3/4 bg-white dark:bg-primary rounded p-5 mx-auto mt-10 mb-20">
        <div>
            <div id="accordion-collapse" data-accordion="collapse">
                <div id="accordion-collapse-heading-1">
                    <button type="button"
                        class="flex items-center justify-between w-full p-4 font-medium text-left  border border-b-0 dark:border-gray-700  dark:bg-gray-700 rounded-t"
                        data-accordion-target="#accordion-collapse-body-1" aria-expanded="true"
                        aria-controls="accordion-collapse-body-1">
                        <span class="text-gray-500 dark:text-gray-400 dark:hover:text-white">Banner
                            Images</span>
                        <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1"
                    x-data="handleInput()">
                    <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-600">
                        <p class="mb-2 text-gray-500 dark:text-gray-200">Example</p>
                        <img src="{{ asset("/img/ExampleLayout/Banner.webp") }}" class="w-auto h-auto rounded-md"
                            alt="Contoh Text Head Nav">
                        @if ($errors->has('img_url.*'))
                        <div class="bg-rose-100 p-2 rounded text-center mt-3 mx-auto">
                            <p class="text-xs text-rose-500 capitalize mt-1">
                                {{ $errors->first('img_url.*') }}
                            </p>
                        </div>
                        @endif
                        @if ($errors->has('img_url'))
                        <div class="bg-rose-100 p-2 rounded text-center mt-3 mx-auto">
                            <p class="text-xs text-rose-500 capitalize mt-1">
                                {{ $errors->first('img_url') }}
                            </p>
                        </div>
                        @endif
                        <form action="{{ URL("dashboard/layout/main/banner/edit") }}" method="POST" class="mt-3">
                            @csrf
                            <div class="grid grid-cols-2 gap-3">
                                <template x-for="(input, index) in inputFields" :key="input">
                                    <div :class="'form_group_' + index" x-show="inputFields.length > 0"
                                        x-transition.duration.500ms>
                                        <p x-text="`IMG URL [${index + 1}]`"
                                            class="text-sm text-slate-500 dark:text-gray-100"></p>
                                        <x-form.input type="text" inputName="img_url[]" name="img_url" label="" />
                                    </div>
                                </template>
                            </div>
                            <div class="flex items-center justify-between gap-4 mt-3">
                                <div class="btn__submit flex items-center space-x-2">
                                    <button class="py-2.5 px-6 rounded bg-primary text-white">Edit Layout</button>
                                    <button data-tooltip-target="tooltip-banner-layout" data-tooltip-style="light"
                                        type="button" class="text-white bg-primary rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                        </svg>
                                    </button>
                                    <div id="tooltip-banner-layout" role="tooltip"
                                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 tooltip">
                                        <span>Ketika admin melakukan edit pada layout, maka layout sebelumnya otomatis
                                            terhapus.</span>
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                                <div class="additional__button flex items-center space-x-3">
                                    <div class="btn__remove__input" x-show="inputFields.length > 1"
                                        x-transition.duration.500ms>
                                        <button @click.prevent="handleRemoveInput()" type="button"
                                            class="bg-rose-400 text-white p-2 flex items-center">
                                            <span>Hapus Input</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6v12m6-6H6" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="btn__add__input">
                                        <button @click.prevent="handleAddInput()" type="button"
                                            class="bg-green-400 text-white p-2 flex items-center">
                                            <span>Tambah Input</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 6v12m6-6H6" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        function handleInput() {
            return {
                inputFields: [],
                currentIndex: 0,

                handleAddInput() {
                    let inputImgUrl = this.inputFields
                    inputImgUrl.push(this.currentIndex + 1)
                    this.currentIndex++;
                },

                handleRemoveInput() {
                    let oldInputImgUrl = this.inputFields
                    oldInputImgUrl.pop()
                    this.currentIndex--;
                }
            }
        }

    </script>
</main>
@endsection
