@if (!empty(request()->query('notif_slug')) && $notifications->isNotEmpty())
<div class="w-full p-5 bg-primary-50 dark:bg-primary-100">
    <form action="{{ URL("dashboard/settings/notifications/add-or-update-notif") }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="notif_title mt-3">
            <x-form.input type="text" inputName="notif_title" value="{{ old('notif_title', $old_notification->notif_title) }}"
                inputClass="w-96 border-0" name="notif_title" label="Notification Title"
                labelClass="uppercase text-xs font-semibold" />
        </div>
        <div class="notif_description mt-3">
            <x-form.input type="text" inputName="notif_description" value="{{ old('notif_description', $old_notification->notif_description) }}"
                inputClass="w-96 border-0" name="notif_description" label="Notification Description"
                labelClass="uppercase text-xs font-semibold" />
        </div>
        <div class="type_notification mt-3">
            <label for="type_notification"
                class="text-xs font-semibold uppercase text-slate-600 dark:text-primary-darker mb-2 block">Type
                Notification</label>
            <select name="type_notif" id="type_notification" style="box-shadow: none;padding: 8px">
                <option value="" disabled>Select Notification Type</option>
                <option value="popup" {{ $old_notification->type_notif === 'popup' ? 'selected' : '' }}>Pop Up</option>
                <option value="redirect" {{ $old_notification->type_notif === 'redirect' ? 'selected' : '' }}>Redirect</option>
            </select>
        </div>
        <div x-data="previewImage()" class="mt-3">
            <label for="type_notification"
                class="text-xs font-semibold uppercase text-slate-600 dark:text-primary-darker mb-2 block">Notification Image</label>
            <label class="cursor-pointer" for="notif_img">
                <div
                    class="w-full h-48 rounded bg-gray-50 dark:bg-gray-100 mt-2 border border-gray-200 flex items-center justify-center overflow-hidden">
                    <img x-show="imageUrl" :src="imageUrl" alt="prev_img" class="w-full object-cover">
                    @if ($old_notification->notif_img)
                    <img x-show="!imageUrl" src="{{ asset('/storage/page/notification/' . $old_notification->notif_img) }}" class="w-full object-cover" alt="">
                    @else
                    <div x-show="!imageUrl" class="text-gray-300 flex flex-col items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <div>Image Preview</div>
                    </div>
                    @endif
                </div>
            </label>
            <input type="hidden" name="old_notif_img" value="{{ $old_notification->notif_img ?? null }}">
            <input class="w-96 cursor-pointer mt-3 focus:outline-0" type="file" name="notif_img" id="notif_img"
                @change="fileChosen">
        </div>
        <input type="hidden" value="{{ $old_notification->notif_slug }}" name="notif_slug">
        <div class="btn_submit">
            <button class="p-2 w-52 rounded bg-primary text-white mt-5 uppercase">save</button>
        </div>
    </form>
</div>
@else
<div class="w-full p-5 bg-primary-50 dark:bg-primary-100">
    <form action="{{ URL("dashboard/settings/notifications/add-or-update-notif") }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="notif_title mt-3">
            <x-form.input type="text" inputName="notif_title" value="{{ old('notif_title') }}"
                inputClass="w-96 border-0" name="notif_title" label="Notification Title"
                labelClass="uppercase text-xs font-semibold" />
        </div>
        <div class="notif_description mt-3">
            <x-form.input type="text" inputName="notif_description" value="{{ old('notif_description') }}"
                inputClass="w-96 border-0" name="notif_description" label="Notification Description"
                labelClass="uppercase text-xs font-semibold" />
        </div>
        <div class="type_notification mt-3">
            <label for="type_notification"
                class="text-xs font-semibold uppercase text-slate-600 dark:text-primary-darker mb-2 block">Type
                Notification</label>
            <select name="type_notif" id="type_notification" style="box-shadow: none;padding: 8px">
                <option value="" selected disabled>Select Notification Type</option>
                <option value="popup">Pop Up</option>
                <option value="redirect">Redirect</option>
            </select>
        </div>
        <div x-data="previewImage()" class="mt-3">
            <label for="type_notification"
                class="text-xs font-semibold uppercase text-slate-600 dark:text-primary-darker mb-2 block">Notification Image</label>
            <label class="cursor-pointer" for="notif_img">
                <div
                    class="w-full h-48 rounded bg-gray-50 dark:bg-gray-100 mt-2 border border-gray-200 flex items-center justify-center overflow-hidden">
                    <img x-show="imageUrl" :src="imageUrl" alt="prev_img" class="w-full object-cover">

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
            <input class="w-96 cursor-pointer mt-3 focus:outline-0" type="file" name="notif_img" id="notif_img"
                @change="fileChosen">
        </div>
        <input type="hidden" value="{{ request()->query('notif_id') }}" name="notif_id">
        <div class="btn_submit">
            <button class="p-2 w-52 rounded bg-primary text-white mt-5 uppercase">save</button>
        </div>
    </form>
</div>
@endif
@push('dashboard-js')
<script>
    new SlimSelect({
        select: '#type_notification',
    })

</script>
@endpush
