@extends('dashboard.layouts.app_dashboard')
@section('header')
Manage SEO Website
@endsection
@section('dashboard_main')
<main class="w-full h-full">
    @if ($mess = Session::get('seo'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-white text-center bg-green-300">{{ $mess }}</div>
    </div>
    @elseif ($mess = Session::get('seo-failed'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-red-500 text-center bg-red-300">{{ $mess }}</div>
    </div>
    @endif
    @if ($errors->any())
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-red-500 text-center bg-red-300">{{ $errors->first() }}</div>
    </div>
    @endif
    <div class="w-full h-full flex justify-center mt-5 mb-5">
        <div class="w-11/12 bg-white rounded p-4">
            <form action="{{ URL('dashboard/settings/add-or-update-seo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="name_of_the_company">
                    <x-form.input inputName="name_of_the_company" name="name_of_the_company" label="Name Of The Company"
                        value="{{ old('name_of_the_company', $data_seo->name_of_the_company ?? null) }}"
                        placeholder="Lapak Murah" />
                </div>
                <div class="keywords mt-3">
                    <x-form.input inputName="keyword" name="keyword" label="Meta Keywords"
                        value="{{ old('keyword', $data_seo->keyword ?? null) }}"
                        placeholder="Website Topup, Murah, ML,PUBG,Pulsa" />
                </div>
                <div class="description mt-3">
                    <x-form.input inputName="description" name="description" label="Meta Description"
                        value="{{ old('description', $data_seo->description ?? null) }}"
                        placeholder="Layanan Website Top Up Termurah" />
                </div>
                <div x-data="previewImage()" class="w-96">
                    <div class="logo_favicon mt-3">
                        <label for="logo_favicon" class="text-sm text-slate-600 dark:text-primary-darker">Logo
                            Favicon</label>
                        <label class="cursor-pointer" for="logo_favicon">
                            <div
                                class="w-full h-72 min-h-max rounded bg-gray-50 dark:bg-gray-100 mt-2 border border-gray-200 flex items-center justify-center overflow-hidden">
                                <img x-show="imageUrl" :src="imageUrl" alt="prev_img" class="w-full object-cover">
                                @if ($data_seo)
                                  @if ($data_seo->logo_favicon)
                                  <img x-show="!imageUrl"
                                      src="{{ asset("/storage/seo/logo/favicon/" . $data_seo->logo_favicon) }}" class="w-full object-cover" alt="old_image_favicon">
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
                        <input class="w-96 cursor-pointer mt-3 focus:outline-0" type="file" name="logo_favicon"
                            id="logo_favicon" @change="fileChosen">
                    </div>
                </div>
                <div x-data="previewImage()" class="w-96">
                    <div class="logo_website mt-3">
                        <label for="logo_website" class="text-sm text-slate-600 dark:text-primary-darker">Logo
                            Website</label>
                        <label class="cursor-pointer" for="logo_website">
                            <div
                                class="w-full h-72 min-h-max rounded bg-gray-50 dark:bg-gray-100 mt-2 border border-gray-200 flex items-center justify-center overflow-hidden">
                                <img x-show="imageUrl" :src="imageUrl" alt="prev_img" class="w-full object-cover">
                                @if ($data_seo)
                                  @if ($data_seo->logo_website)
                                  <img x-show="!imageUrl"
                                      src="{{ asset("/storage/seo/logo/website/" . $data_seo->logo_website) }}" class="w-full object-cover" alt="old_image_website">
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
                        <input class="w-96 cursor-pointer mt-3 focus:outline-0" type="file" name="logo_website"
                            id="logo_website" @change="fileChosen">
                    </div>
                </div>
                <input type="hidden" name="seo_id" value="{{ $data_seo->id ?? null }}">
                <input type="hidden" name="old_favicon_img" value="{{ $data_seo->logo_favicon ?? null }}">
                <input type="hidden" name="old_website_img" value="{{ $data_seo->logo_website ?? null }}">
                <div class="btn_submit mt-8">
                    <button class="py-2 px-24 rounded bg-primary text-white">Save</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
