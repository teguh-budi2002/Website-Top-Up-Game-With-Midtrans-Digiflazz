@foreach ($oldCustomFields as $customField)
 <div class="p-5 bg-primary-50 dark:bg-primary-100">
    <p class="mb-3 font-extrabold uppercase text-primary-light">Order Page: <span class="font-light">{{ str_replace("-", " ",request()->query('slug')) }}</span></p>
           <form action="{{ URL("dashboard/order-page/" . $customField->page_slug . "/setting") }}" method="POST" enctype="multipart/form-data">
           @csrf
               <div class="text_title_box1">
                   <x-form.input type="text" value="{{ old('text_title_on_order_page', $customField->text_title_on_order_page) }}" inputName="text_title_on_order_page" inputClass="w-96 dark:text-slate-700 dark:bg-white border-0" name="img_url"
                       label="Text Title Box 1" placeholder=" ex: 'Masukkan Player ID Anda'"
                       labelClass="dark:text-primary-darker uppercase text-xs font-semibold" />
               </div>
               <div class="description_box1 mt-3">
                   <x-form.input type="text" inputName="description_on_order_page" value="{{ old('description_on_order_page', $customField->description_on_order_page) }}" inputClass="w-96 dark:text-slate-700 dark:bg-white border-0" name="img_url"
                       label="Description Box 1"
                       placeholder=" ex: 'Untuk menemukan ID anda, Klik pada ikon karakter ....'"
                       labelClass="dark:text-primary-darker uppercase text-xs font-semibold" />
               </div>
               <div class="detail_product mt-3">
                   <label for="detail_product" class="block mb-2 text-xs uppercase font-semibold text-gray-800 dark:text-primary-darker">Detail Product (Opsional)</label>
                   <textarea name="detail_for_product" class="w-full rounded-md dark:text-slate-700 border-0" id="detail_product" rows="6">{{ $customField->detail_for_product }}</textarea>
               </div>
               <div class="bg_image_for_page">
                   <label for="custom_bg" class="block mt-3 uppercase font-semibold text-gray-800 dark:text-primary-darker text-xs">Custom
                       Background Image Page</label>
                   <div x-data="previewImage()">
                       <label class="cursor-pointer" for="custombgImg{{ $customField->id }}">
                           <div
                               class="w-full h-48 rounded bg-gray-50 dark:bg-gray-100 mt-2 border border-gray-200 flex items-center justify-center overflow-hidden">
                               <img x-show="imageUrl" :src="imageUrl" alt="prev_img" class="w-full object-cover">
                               @if ($customField->bg_img_on_order_page)
                               <img x-show="!imageUrl" src="{{ asset("/storage/" . $customField->bg_img_on_order_page) }}" alt="old_image">
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
                       <input type="hidden" name="oldImg" value="{{ $customField->bg_img_on_order_page ?? null }}">
                       <input class="w-96 cursor-pointer mt-3 focus:outline-0" type="file" name="bg_img_on_order_page" id="custombgImg{{ $customField->id }}" @change="fileChosen">
                   </div>
               </div>
               <div class="btn_submit">
                   <button class="p-2 w-52 rounded bg-primary text-white mt-5 uppercase">save</button>
               </div>
           </form>
       </div>
@endforeach

