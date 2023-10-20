@if (!empty(request()->query('provider_name')) && $providers->isNotEmpty())
<div class="w-full p-5 bg-primary-50 dark:bg-primary-100">
    <p class="mb-3 font-extrabold uppercase text-primary-light">Provider: <span
            class="font-light">{{ str_replace("-", " ", request()->query('provider_name')) }}</span></p>
    <form action="{{ URL("dashboard/settings/provider/add-or-update-provider") }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="p_name">
          <label for="p_name" class="text-xs font-semibold uppercase text-slate-600 dark:text-primary-darker mb-2 block">Provider</label>
            <select name="provider_name" id="p_name" style="box-shadow: none;padding: 8px">
              <option value="{{ $oldProvider->provider_name }}" selected>{{ Str::ucfirst($oldProvider->provider_name) }}</option>       
            </select>
        </div>
        <div class="username mt-3">
            <x-form.input type="text" inputName="username"
                value="{{ old('username', $oldProvider->username) }}"
                inputClass="w-96 border-0" name="username" label="Username Key"
                labelClass="uppercase text-xs font-semibold" />
        </div>
        <div class="key mt-3">
            <x-form.input type="text" inputName="key"
                value="{{ old('key', $oldProvider->key) }}"
                inputClass="w-96 border-0" name="key" label="Server Key"
                labelClass="uppercase text-xs font-semibold" />
        </div>
        <input type="hidden" value="{{ $oldProvider->id }}" name="provider_id">
        <div class="btn_submit">
            <button type="submit" class="p-2 w-52 rounded bg-primary text-white mt-5 uppercase">save</button>
        </div>
    </form>
</div>
@else
<div class="w-full p-5 bg-primary-50 dark:bg-primary-100">
    <form action="{{ URL("dashboard/settings/provider/add-or-update-provider") }}" method="POST">
        @csrf
        <div class="p_name">
            <label for="p_name" class="text-xs font-semibold uppercase text-slate-600 dark:text-primary-darker mb-2 block">Provider</label>
            <select name="provider_name" id="p_name" style="box-shadow: none;padding: 8px">
              <option value="" selected readonly>Select Provider</option>
              <option value="Digiflazz">DIGIFLAZZ</option>
              <option value="Apigames">APIGAMES</option>
            </select>
        </div>
        <div class="username mt-3">
            <x-form.input type="text" inputName="username"
                value="{{ old('username') }}"
                inputClass="w-96 border-0" name="username" label="Username Key"
                labelClass="uppercase text-xs font-semibold" />
        </div>
        <div class="key mt-3">
            <x-form.input type="text" inputName="key"
                value="{{ old('key') }}"
                inputClass="w-96 border-0" name="key" label="Provider Key"
                labelClass="uppercase text-xs font-semibold" />
        </div>
        <div class="btn_submit">
            <button type="submit" class="p-2 w-52 rounded bg-primary text-white mt-5 uppercase">save</button>
        </div>
    </form>
</div>
@endif

@push('dashboard-js')
  <script>
    new SlimSelect({
        select: '#p_name',
        settings: {
            placeholderText: 'Select Provider',
        }
    })
  </script>
@endpush