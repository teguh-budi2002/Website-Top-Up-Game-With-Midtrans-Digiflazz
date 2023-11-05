@extends('dashboard.layouts.app_dashboard')
@section('header')
Manage Social Media
@endsection
@section('dashboard_main')
<main class="w-full h-full overflow-x-hidden">
    @if ($mess = Session::get('sosmed'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-white text-center bg-green-300">{{ $mess }}</div>
    </div>
    @elseif ($mess = Session::get('sosmed-failed'))
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
            <div class="w-full h-fit grid grid-cols-1 gap-2 md:mx-16 mx-3">
                <div class="w-full h-auto rounded bg-white shadow-md p-4 mt-5 mb-5">
                    <form action="{{ URL('dashboard/settings/social-media/add-or-update-social-media') }}" method="POST">
                      @csrf
                       <div class="instagram mt-3">
                          <x-form.input type="text" inputName="instagram"
                              value="{{ old('instagram', $social_media->instagram) }}"
                              name="instagram" label="Instagram URL"
                              labelClass="uppercase text-xs font-semibold" />
                      </div>
                       <div class="facebook mt-3">
                          <x-form.input type="text" inputName="facebook"
                              value="{{ old('facebook', $social_media->facebook) }}"
                              name="facebook" label="Facebook URL"
                              labelClass="uppercase text-xs font-semibold" />
                      </div>
                       <div class="whatsapp mt-3">
                          <x-form.input type="text" inputName="whatsapp"
                              value="{{ old('whatsapp', $social_media->whatsapp) }}"
                              name="whatsapp" label="Whatsapp Bussiness"
                              labelClass="uppercase text-xs font-semibold" />
                      </div>
                       <div class="email mt-3">
                          <x-form.input type="text" inputName="email"
                              value="{{ old('email', $social_media->email) }}"
                              name="email" label="Email Bussiness"
                              labelClass="uppercase text-xs font-semibold" />
                      </div>
                      <input type="hidden" value="{{ $social_media->id }}" name="social_media_id">
                      <div class="btn_submit">
                        <button class="p-2 w-52 rounded bg-primary text-white mt-5 uppercase">save</button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection