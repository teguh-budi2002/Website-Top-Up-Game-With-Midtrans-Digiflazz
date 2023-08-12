{{-- If Product Not Null --}}
@if ($products->count())
{{-- If CustomField Not Null --}}
@if ($oldCustomFields->count())
@foreach ($products as $product)
@foreach ($oldCustomFields as $oldValue)
    <div id="accordion-collapse" class="mt-3" data-accordion="collapse">
        <h2 id="accordion-collapse-heading-{{ $product->id }}">
            <button type="button"
                class="flex items-center justify-between w-full p-5 font-medium text-left bg-gray-400 dark:bg-black hover:bg-gray-300 text-white rounded-t transition-colors duration-150"
                data-accordion-target="#accordion-collapse-body-{{ $product->id }}" aria-expanded="true"
                aria-controls="accordion-collapse-body-{{ $product->id }}">
                <span>{{ $loop->iteration }}. Manage Page Order Product On [ <span
                        class="uppercase underline text-slate-700 hover:text-slate-300 transition duration-150">{{ $product->product_name }}</span> ]</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h2>
        <div id="accordion-collapse-body-{{ $product->id }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $product->id }}">
            <div class="p-5 bg-gray-100 dark:bg-white">
                <form action="{{ URL("dashboard/order-page/" . $product->slug . "/setting") }}" method="POST" enctype="multipart/form-data">
                  @csrf
                    <div class="text_title_box1">
                        <x-form.input type="text" value="{{ old('text_title_on_order_page', $oldValue->text_title_on_order_page) }}" inputName="text_title_on_order_page" inputClass="w-96" name="img_url"
                            label="Text Title Box 1" placeholder=" ex: 'Masukkan Player ID Anda'"
                            labelClass="dark:text-black uppercase font-semibold" />
                    </div>
                    <div class="description_box1 mt-3">
                        <x-form.input type="text" inputName="description_on_order_page" value="{{ old('description_on_order_page', $oldValue->description_on_order_page) }}" inputClass="w-96" name="img_url"
                            label="Description Box 1"
                            placeholder=" ex: 'Untuk menemukan ID anda, Klik pada ikon karakter ....'"
                            labelClass="dark:text-black uppercase font-semibold" />
                    </div>
                     <div class="detail_product mt-3">
                        <label for="detail_product" class="block mb-2 text-sm uppercase font-semibold text-gray-800 dark:text-white">Detail Product (Opsional)</label>
                        <textarea name="detail_for_product" class="w-full" id="detail_product" rows="6">{{ $oldValue->detail_for_product }}</textarea>
                    </div>
                    <div class="bg_image_for_page">
                        <label for="custom_bg" class="block mt-3 uppercase font-semibold text-gray-800 text-sm">Custom
                            Background Image Page</label>
                        <div x-data="previewImage()">
                            <label class="cursor-pointer" for="custombgImg{{ $product->id }}">
                                <div
                                    class="w-full h-48 rounded bg-gray-50 dark:bg-gray-100 mt-2 border border-gray-200 flex items-center justify-center overflow-hidden">
                                    <img x-show="imageUrl" :src="imageUrl" alt="prev_img" class="w-full object-cover">
                                    @if ($oldValue->bg_img_on_order_page)
                                    <img x-show="!imageUrl" src="{{ asset("/storage/" . $oldValue->bg_img_on_order_page) }}" alt="old_image">
                                    @else
                                    <div x-show="!imageUrl" class="text-gray-300 flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <div>Image Preview</div>
                                    </div>
                                    @endif
                                </div>
                            </label>
                            <input type="hidden" name="oldImg" value="{{ $oldValue->bg_img_on_order_page ?? null }}">
                            <input class="w-96 cursor-pointer mt-3 focus:outline-0" type="file" name="bg_img_on_order_page" id="custombgImg{{ $product->id }}" @change="fileChosen">
                        </div>
                    </div>
                    <div class="btn_submit">
                        <button class="p-2 w-52 rounded bg-primary text-white mt-5 uppercase">save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endforeach
{{-- If CustomField Or Product Is NULL --}}
@else
@foreach ($products as $product)
    <div id="accordion-collapse" class="mt-3" data-accordion="collapse">
        <h2 id="accordion-collapse-heading-{{ $product->id }}">
            <button type="button"
                class="flex items-center justify-between w-full p-5 font-medium text-left bg-gray-400 dark:bg-black hover:bg-gray-300 text-white rounded-t transition-colors duration-150"
                data-accordion-target="#accordion-collapse-body-{{ $product->id }}" aria-expanded="true"
                aria-controls="accordion-collapse-body-{{ $product->id }}">
                <span>{{ $loop->iteration }}. Manage Page Order Product On [ <span
                        class="uppercase underline text-slate-700 hover:text-slate-300 transition duration-150">{{ $product->product_name }}</span> ]</span>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h2>
        <div id="accordion-collapse-body-{{ $product->id }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $product->id }}">
            <div class="p-5 bg-gray-100 dark:bg-white">
                <form action="{{ URL("dashboard/order-page/" . $product->slug . "/setting") }}" method="POST" enctype="multipart/form-data">
                  @csrf
                    <div class="text_title_box1">
                        <x-form.input type="text" inputName="text_title_on_order_page" inputClass="w-96" name="img_url"
                            label="Text Title Box 1" placeholder=" ex: 'Masukkan Player ID Anda'"
                            labelClass="dark:text-black uppercase font-semibold" />
                    </div>
                    <div class="description_box1 mt-3">
                        <x-form.input type="text" inputName="description_on_order_page" inputClass="w-96" name="img_url"
                            label="Description Box 1"
                            placeholder=" ex: 'Untuk menemukan ID anda, Klik pada ikon karakter ....'"
                            labelClass="dark:text-black uppercase font-semibold" />
                    </div>
                     <div class="detail_product mt-3">
                        <label for="detail_product" class="block mb-2 text-sm uppercase font-semibold text-gray-800 dark:text-white">Detail Product (Opsional)</label>
                        <textarea name="detail_for_product" class="w-full" id="detail_product" rows="6"></textarea>
                    </div>
                    <div class="bg_image_for_page">
                        <label for="custom_bg" class="block mt-3 uppercase font-semibold text-gray-800 text-sm">Custom
                            Background Image Page</label>
                        <div x-data="previewImage()">
                            <label class="cursor-pointer" for="custombgImg{{ $product->id }}">
                                <div
                                    class="w-full h-48 rounded bg-gray-50 dark:bg-gray-100 mt-2 border border-gray-200 flex items-center justify-center overflow-hidden">
                                    <img x-show="imageUrl" :src="imageUrl" alt="prev_img" class="w-full object-cover">

                                    <div x-show="!imageUrl" class="text-gray-300 flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <div>Image Preview</div>
                                    </div>
                                </div>
                            </label>
                            <input type="hidden" name="oldImg" value="{{ $oldValue->bg_img_on_order_page ?? null }}">
                            <input class="w-96 cursor-pointer mt-3 focus:outline-0" type="file" name="bg_img_on_order_page" id="custombgImg{{ $product->id }}" @change="fileChosen">
                        </div>
                    </div>
                    <div class="btn_submit">
                        <button class="p-2 w-52 rounded bg-primary text-white mt-5 uppercase">save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endif   
@else
<div class="text-center">
  <p class="capitalize text-xl">Please create a product first before placing a custom order page.</p>
  <a href="{{ URL('dashboard/products') }}" class="text-blue-300 hover:text-blue-500">Click here!</a>
</div>
@endif
