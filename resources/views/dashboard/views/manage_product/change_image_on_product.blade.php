@extends('dashboard.layouts.app_dashboard')
@section('header')
Manage Image on Product
@endsection
@section('dashboard_main')
<main class="w-full h-full">
  <div class="flex justify-center">
    <div class="w-2/6 bg-white shadow-md rounded p-4 mt-10">
      <p class="text-primary font-semibold uppercase">{{ $product->product_name }}</p>
        <form action="{{ URL('dashboard/change-image-on-product/process/' . $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="image_product w-full">
                <label for="custom_img_product" class="block mt-3 text-slate-600 dark:text-primary-dark text-sm">Change Product Photo</label>
                <div x-data="previewImage()">
                    <label class="cursor-pointer" for="changeImgProduct">
                        <div class="w-full h-48 rounded bg-gray-50 dark:bg-gray-100 mt-2 border border-gray-200 flex items-center justify-center overflow-hidden">
                            <img x-show="imageUrl" :src="imageUrl" alt="preview_img" class="w-32 h-32 object-cover">
                            <div x-show="!imageUrl" class="text-gray-300 flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <div>Image Preview</div>
                            </div>
                        </div>
                    </label>
                    <input class="w-96 cursor-pointer mt-3 focus:outline-0" type="file" name="img_url" id="changeImgProduct"
                        @change="fileChosen">
                </div>
            </div>
            <input type="hidden" name="product_name" value="{{ $product->product_name }}">
            <div class="mt-5">
              <button class="w-full py-2 px-24 rounded bg-primary text-white">Save</button>
            </div>
        </form>
    </div>
  </div>
</main>
@endsection
