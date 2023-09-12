<div class="add_payment_method">
    <form action="{{ URL('dashboard/add-payment-method') }}" method="POST">
        @csrf
        <div class="products w-full">
            <label for="productSelect" class="text-sm font-medium dark:text-gray-900 uppercase">choose product</label>
            <select id="productSelect" class="mt-2 mb-2 slimselect_shadow_none" style="box-shadow: none;padding: 8px" name="product_id"
                class="">
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="payment_methods w-full">
            <label for="multiSelect" class="text-sm font-medium dark:text-gray-900 uppercase">payment method</label>
            <select id="multiSelect" name="payment_method_ids[]" class="mt-2 mb-2 slimselect-shadow-none;padding: 8px" style="box-shadow: none" multiple>
                @foreach ($payment_methods as $payment)
                    <option value="{{ $payment->id }}">{{ $payment->payment_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="btn mt-1">
            <button type="submit" class="py-2.5 px-8 rounded bg-primary dark:bg-primary-dark text-white">Add
                Payment</button>
        </div>
    </form>
</div>

@push('dashboard-js')
<script>
    new SlimSelect({
        select: '#multiSelect',
        settings: {
            placeholderText: 'Select Payment Methods',
        }
      })

    new SlimSelect({
        select: '#productSelect',
        settings: {
            placeholderText: 'Select Products',
        }
      })
</script>
@endpush
