@extends('dashboard.layouts.app_dashboard')
@section('header')
Manage Banner Layout
@endsection
@section('dashboard_main')
<main class="w-full h-auto">
    @if ($mess = Session::get('edit_banner_layout_success'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-white text-center bg-green-300">{{ $mess }}</div>
    </div>
    @elseif ($mess = Session::get('extension-error'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-red-500 text-center bg-red-300">{{ $mess }}</div>
    </div>
    @endif
    @if ($errors->any())
        <div class="mx-16 mt-4">
            @foreach ($errors->all() as $err)
                    <div class="p-2 rounded text-red-500 text-center bg-red-300">{{ $err }}</div>
            @endforeach
        </div>
    @endif
    <div class="w-3/4 bg-white rounded p-5 mx-auto mt-10 mb-20">
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
                        @if (!is_null($banner))
                        <div class="relative w-full flex flex-col justify-center items-center" x-data="handleBanner()">
                            <div style="border-radius: 6px" class="md:w-[800px] w-full h-[390px] flex overflow-x-hidden relative">
                                @foreach ($banner->img_url as $key => $img)
                                <div class="absolute inset-x-0" x-show="isActiveSlide({{ $key + 1 }})"
                                    x-transition:enter="transition duration-1000" x-transition:enter-start="transform translate-x-full"
                                    x-transition:enter-end="transform translate-x-0" x-transition:leave="transition duration-1000"
                                    x-transition:leave-start="transform" x-transition:leave-end="transform -translate-x-full">
                                    <img x-cloak class="md:w-[800px] w-full h-96 object-cover rounded-md mx-auto" alt="example banner" src="{{ asset("/storage/" . $img) }}" />
                                </div>
                                @endforeach
                            </div>
                            <div class="flex justify-center items-center space-x-4 mt-4">
                                @foreach ($banner->img_url as $key => $value)
                                <button :class="isActiveSlide({{ $key + 1 }}) ? 'bg-primary-cyan-light' : 'bg-teal-600'"
                                    class="w-9 h-1.5 rounded hover:bg-primary-cyan-light cursor-pointer"
                                    @click="activeSlides = {{ $key + 1 }}"></button>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <img src="{{ asset("/img/ExampleLayout/Banner.webp") }}" class="w-auto h-auto rounded-md" alt="Contoh Banner">
                        @endif
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
                        <form action="{{ URL("dashboard/layout/main/banner/edit") }}" method="POST" class="mt-3"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-2 gap-3">
                                <template x-for="(input, index) in inputFields" :key="input">
                                    <div :class="'form_group_' + index" x-show="inputFields.length > 0"
                                        x-transition.duration.500ms>
                                        <div x-data="previewImage()">
                                            <label class="cursor-pointer" :for="`img_url_${index}`">
                                                <div
                                                    class="w-full h-48 rounded bg-gray-50 dark:bg-gray-100 mt-2 border border-gray-200 flex items-center justify-center overflow-hidden">
                                                    <img x-show="imageUrl" :src="imageUrl" alt="prev_img"
                                                        class="w-full object-cover">

                                                    <div x-show="!imageUrl"
                                                        class="text-gray-300 flex flex-col items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                        </svg>
                                                        <div>Image Preview</div>
                                                    </div>
                                                </div>
                                            </label>
                                            <p x-text="`IMG URL [${index + 1}]`" class="mt-2 text-sm text-slate-500 dark:text-gray-100"></p>
                                            <input class="w-96 cursor-pointer mt-3 focus:outline-0" type="file"
                                            name="images[]" :id="`img_url_${index}`"
                                            @change="fileChosen">
                                        </div>
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
                                        <span>When the admin edits the banner layout, the previous banner layout is automatically deleted.</span>
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </div>
                                <div class="additional__button flex items-center space-x-3">
                                    <div class="btn__remove__input" x-show="inputFields.length > 1"
                                        x-transition.duration.500ms>
                                        <button @click.prevent="handleRemoveInput()" type="button"
                                            class="bg-rose-400 text-white p-2 flex items-center">
                                            <span>Delete One Input</span>
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
                                            <span>Add More Image</span>
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

     function handleBanner() {
         return {
             activeSlides: 1,
             imgUrls: [],

             init() {
                this.imgUrls = {!! json_encode($banner->img_url ?? []) !!}
                this.startAutoSlide();
             },

             isActiveSlide(slideIndex) {
                return this.activeSlides === slideIndex;
            },

            startAutoSlide() {
                setInterval(() => {
                    this.activeSlides = (this.activeSlides % this.imgUrls.length) + 1;
                }, 4000);
            },
        }
    }

</script>
</main>
@endsection
