@if (!empty(request()->query('pg_name')) && $payment_gateway->isNotEmpty())
<div class="w-full p-5 bg-primary-50 dark:bg-primary-100">
    <p class="mb-3 font-extrabold uppercase text-primary-light">Provider: <span
            class="font-light">{{ str_replace("-", " ", request()->query('pg_name')) }}</span></p>
    <form action="{{ URL("dashboard/settings/payment-gateway/add-or-update-pg") }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="pg_name">
          <label for="pg" class="text-xs font-semibold uppercase text-slate-600 dark:text-primary-darker mb-2 block">Prodiver Payment Gateway</label>
            <select name="payment_name" id="pg" style="box-shadow: none;padding: 8px">
              <option value="{{ $old_payment_gateway->payment_name }}" selected>{{ Str::ucfirst($old_payment_gateway->payment_name) }}</option>       
            </select>
        </div>
        <div class="client_key mt-3">
            <x-form.input type="text" inputName="client_key"
                value="{{ old('client_key', $old_payment_gateway->client_key) }}"
                inputClass="w-96 border-0" name="client_key" label="Client Key"
                labelClass="uppercase text-xs font-semibold" />
        </div>
        <div class="server_key mt-3">
            <x-form.input type="text" inputName="server_key"
                value="{{ old('server_key', $old_payment_gateway->server_key) }}"
                inputClass="w-96 border-0" name="server_key" label="Server Key"
                labelClass="uppercase text-xs font-semibold" />
        </div>
      <input type="hidden" value="{{ $old_payment_gateway->id }}" name="pg_id">
        <div class="btn_submit">
            <button class="p-2 w-52 rounded bg-primary text-white mt-5 uppercase">save</button>
        </div>
    </form>
</div>
@else
<div class="w-full p-5 bg-primary-50 dark:bg-primary-100">
    <form action="{{ URL("dashboard/settings/payment-gateway/add-or-update-pg") }}" method="POST">
        @csrf
        <div class="pg_name">
            <label for="pg" class="text-xs font-semibold uppercase text-slate-600 dark:text-primary-darker mb-2 block">Prodiver Payment Gateway</label>
            <select name="payment_name" id="pg" style="box-shadow: none;padding: 8px">
              <option value="" selected disabled>Select Payment Method Provider</option>
              <option value="midtrans">Midtrans</option>
              <option value="tripay">Tripay</option>
              <option value="xendit">Xendit</option>
            </select>
        </div>
        <div class="client_key mt-3">
            <x-form.input type="text" inputName="client_key"
                value="{{ old('client_key') }}"
                inputClass="w-96 border-0" name="client_key" label="Client Key"
                labelClass="uppercase text-xs font-semibold" />
        </div>
        <div class="server_key mt-3">
            <x-form.input type="text" inputName="server_key"
                value="{{ old('server_key') }}"
                inputClass="w-96 border-0" name="server_key" label="Server Key"
                labelClass="uppercase text-xs font-semibold" />
        </div>
      <input type="hidden" value="{{ request()->query('pg_name') }}" name="pg_name">
        <div class="btn_submit">
            <button class="p-2 w-52 rounded bg-primary text-white mt-5 uppercase">save</button>
        </div>
    </form>
</div>
@endif

@push('dashboard-js')
  <script>
    new SlimSelect({
        select: '#pg',
        settings: {
            placeholderText: 'Select Payment Method Provider',
        }
    })
  </script>
@endpush