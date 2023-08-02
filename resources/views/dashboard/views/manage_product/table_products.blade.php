<div x-data="{ showBtn: false, selectedRecord: [] }" x-init="$watch('selectedRecord', (val) => {
    if (val.length) {
        showBtn = true
    } else {
        showBtn = false
    }
})" class="p-4 mt-2">
    <div class="w-full mx-auto bg-white dark:bg-darker shadow-lg rounded-sm">
        <div class="grid grid-cols-2 border-b dark:border-primary-darker">

            {{-- Search Product --}}
            @include('dashboard.views.manage_product.search_product')

            <div class="px-5 py-4 border-b dark:border-primary-darker flex items-center justify-end space-x-3">
                <div>
                    <button x-show="showBtn" x-transition.duration.500ms
                        class="w-fit bg-red-500 hover:bg-red-600 text-white p-1.5 px-4 rounded cursor-pointer"
                        id="btnDeleteAllRecords" type="submit">
                        <span>DELETED SELECTED PRODUCTS</span>
                    </button>
                </div>
                <div data-modal-target="add_product" data-modal-toggle="add_product">
                    <button
                        class="w-fit bg-primary hover:bg-primary-dark dark:bg-primary-light dark:hover:bg-primary-dark text-white flex items-center p-1.5 px-4 rounded cursor-pointer"
                        type="button">
                        <span>ADD PRODUCT</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-8 h-8 p-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
            </div>

        </div>

        {{-- Modal ADD PRODUCT Component --}}
        <x-dashboard.form-modal actionUrl="dashboard/product" enctype="multipart/form-data" modalId="add_product" modalToggle="add_product">
            <x-slot:modalHeader>
                Add Product
            </x-slot:modalHeader>
            <x-slot:inputBox>
                <x-form.input type="text" inputName="product_name" name="name_game" label="Masukkan Nama Product" />
                {{-- <x-form.input type="text" inputName="img_url" name="img_url" label="Masukkan Img URL Product" /> --}}
                <div class="image_for_product">
                    <label for="custom_bg_product" class="block mt-3 uppercase font-semibold text-gray-800 text-sm">Add Photo Into Product</label>
                    <div x-data="previewImage()">
                        <label class="cursor-pointer" for="custombgImg">
                            <div
                                class="w-full h-48 rounded bg-gray-50 dark:bg-gray-100 mt-2 border border-gray-200 flex items-center justify-center overflow-hidden">
                                <img x-show="imageUrl" :src="imageUrl" alt="preview_img" class="w-full object-cover">
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
                        <input class="w-96 cursor-pointer mt-3 focus:outline-0" type="file" name="img_url"
                            id="custombgImg" @change="fileChosen">
                    </div>
                </div>
            </x-slot:inputBox>
        </x-dashboard.form-modal>

        <div class="overflow-x-auto p-3">
            <table class="w-full">
                <thead
                    class="text-xs font-semibold uppercase text-white dark:text-light bg-primary hover:bg-primary-dark">
                    <tr>
                        <th></th>
                        <th class="p-2">
                            <div class="font-semibold text-left">Product Image</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-left">Product Name</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Items</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Payment Method</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-left">Created At</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Action</div>
                        </th>
                    </tr>
                </thead>

                <tbody class="text-sm text-primary dark:text-primary-light divide-y divide-gray-100">
                    @if (count($products))
                    @foreach ($products as $product)
                    <tr id="productIds{{ $product->id }}">
                        <td class="p-2">
                            <input type="checkbox" autocomplete="off" name="checked_record_ids" x-model="selectedRecord"
                                id="selected_items"
                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2 dark:bg-primary-dark cursor-pointer"
                                value="{{ $product->id }}" />
                        </td>
                        <td class="p-2">
                            <img class="w-10 h-10 rounded mx-auto" src="{{ asset('/storage/product/' . $product->product_name . '/' . $product->img_url) }}" alt="image_{{ $product->product_name }}">
                        </td>
                        <td class="p-2">
                            <div class="font-medium">
                                {{ $product->product_name }}
                            </div>
                        </td>
                        <td class="p-2 text-center">
                            <button data-modal-target="showInfoItems{{ $product->id }}" type="button"
                                data-modal-toggle="showInfoItems{{ $product->id }}"
                                class="border-[1px] border-primary-dark p-2 rounded hover:bg-primary-dark hover:text-white transition">Show
                                Items</button>
                            {{-- Info Item Modal Component --}}
                            <x-dashboard.info-modal modalId="showInfoItems{{ $product->id }}" titleModal="INFO ITEM">
                                <x-slot:info>
                                    @if ($product->items->count())
                                    <div class="flex items-center gap-2 flex-wrap">
                                        @foreach ($product->items as $item)
                                        <div
                                            class="items w-[200px] h-[100px] bg-gray-100/30 flex flex-col justify-center items-center space-y-2 rounded-md p-2 border border-gray-400 border-solid cursor-pointer">
                                            <p class="font-semibold capitalize">{{ $item->nominal }} -
                                                {{ $item->item_name }}</p>
                                            <p class="text-xs">Harga</p>
                                            <p class="text-sm text-rose-600">Rp. {{ Cash($item->price, 2) }}</p>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <p class="text-2xl uppercase dark:text-primary-light">Product of
                                        <span class="text-red-400">{{ $product->product_name }}</span> don't have any items yet.
                                    </p>
                                    @endif
                                </x-slot:info>
                                <x-slot name="footer">
                                    <div class="flex items-center space-x-2 rounded-b">
                                        <button data-modal-hide="showInfoItems{{ $product->id }}" type="button"
                                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-primary-dark dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-primary dark:focus:ring-gray-600 transition">Close</button>
                                    </div>
                                </x-slot>
                            </x-dashboard.info-modal>
                        </td>
                        <td class="p-2 text-center">
                            <button data-modal-target="showInfoPayment{{ $product->id }}" type="button"
                                data-modal-toggle="showInfoPayment{{ $product->id }}"
                                class="border-[1px] border-primary-dark p-2 rounded hover:bg-primary-dark hover:text-white transition">Supported
                                Payment Methods</button>
                            {{-- Info Payment Method Modal Component --}}
                            <x-dashboard.info-modal modalId="showInfoPayment{{ $product->id }}"
                                titleModal="PAYMENT METHOD SUPPORTED ON PRODUCT">
                                <x-slot:info>
                                    @if ($product->paymentMethods->count())
                                    <div class="flex items-center gap-2 flex-wrap">
                                        @foreach ($product->paymentMethods as $payment)
                                        <img src="{{ asset("/img/" . $payment->img_static) }}" class="w-auto h-5"
                                            alt="{{ $payment->payment_name }}">
                                        @endforeach
                                    </div>
                                    @else
                                    <p class="text-2xl uppercase dark:text-primary-light">
                                        Please indicate payment method on product <span
                                            class="text-rose-400">{{ $product->product_name }}</span>
                                    </p>
                                    <a href="{{ URL("dashboard/payment-product") }}"
                                        class="text-blue-300 hover:text-blue-500 mt-2">Click here!</a>
                                    @endif
                                </x-slot:info>
                                <x-slot name="footer">
                                    <div class="flex items-center space-x-2 rounded-b">
                                        <button data-modal-hide="showInfoPayment{{ $product->id }}" type="button"
                                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-primary-dark dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-primary dark:focus:ring-gray-600 transition">Close</button>
                                    </div>
                                </x-slot>
                            </x-dashboard.info-modal>
                        </td>
                        <td class="p-2">
                            <div class="text-left font-medium text-green-500">
                                {{ DateFormat($product->created_at, 'd-F-Y') }}
                            </div>
                        </td>
                        <td class="p-2">
                            <div class="flex justify-center">
                                <button data-popover-target="popover-add-items"
                                    data-modal-target="add_item_on_product{{ $product->id }}"
                                    data-modal-toggle="add_item_on_product{{ $product->id }}"
                                    data-popover-placement="bottom" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-8 h-8 hover:text-blue-600 rounded-full hover:bg-gray-100 p-1">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </button>
                                <div data-popover id="popover-add-items" role="tooltip"
                                    class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border dark:border-primary-dark rounded opacity-0 dark:text-white dark:bg-primary-dark">
                                    <div class="px-3 py-2 text-center">
                                        <p>Add Items On Product</p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>
                                <button type="button" data-modal-target="deleteProductModal{{ $product->id }}"
                                    data-modal-toggle="deleteProductModal{{ $product->id }}">
                                    <svg class="w-8 h-8 hover:text-blue-600 rounded-full hover:bg-gray-100 p-1"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                                {{-- Delete Product + Items Modal Component --}}
                                <x-dashboard.info-modal modalId="deleteProductModal{{ $product->id }}"
                                    titleModal="DELETED PRODUCT">
                                    <x-slot:info>
                                        <h2 class="text-3xl text-red-400 dark:text-primary-light text-center">WARNING!
                                        </h2>
                                        <p class="dark:text-white text-lg">By deleting a product, The items in product also will be deleted.</p>
                                    </x-slot:info>
                                    <x-slot name="footer">
                                        <form action="{{ URL('dashboard/product/' . $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="py-2.5 px-6 bg-red-600 hover:bg-red-400 transition rounded text-white">Yes, Delete</button>
                                        </form>
                                    </x-slot>
                                </x-dashboard.info-modal>
                            </div>
                            {{-- Form Modal ADD ITEMS Component --}}
                            <x-dashboard.form-modal actionUrl="dashboard/item/store"
                                modalId="add_item_on_product{{ $product->id }}"
                                modalToggle="add_item_on_product{{ $product->id }}">
                                <x-slot:modalHeader>
                                    Add Items On Product
                                </x-slot:modalHeader>
                                <x-slot:inputBox>
                                    @if ($product->items->count())
                                    @foreach ($product->items->take(1) as $item)
                                    <x-form.input type="text" inputName="item_name"
                                        value="{{ old('item_name', $item->item_name) }}" name="item_name"
                                        label="Masukkan Nama Item" />
                                    @endforeach
                                    @else
                                    <x-form.input type="text" inputName="item_name" name="item_name"
                                        label="Masukkan Nama Item" />
                                    @endif
                                    <x-form.input type="text" inputName="nominal" name="nominal"
                                        label="Jumlah Nominal Pada Item" />
                                    <x-form.input type="number" inputName="price" name="price" label="Harga Item" />
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </x-slot:inputBox>
                            </x-dashboard.form-modal>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <div class="mt-2 mb-3">
                        <p class="text-2xl text-center uppercase dark:text-primary-light">The product hasn't been
                            created yet
                        </p>
                    </div>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('dashboard-js')
<script>
function previewImage() {
    return {
        imageUrl: "",

        fileChosen(event) {
            this.fileToDataUrl(event, (src) => (this.imageUrl = src));
            console.log(event)
        },

        fileToDataUrl(event, callback) {
            if (!event.target.files.length) return;

            let file = event.target.files[0],
                reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = (e) => callback(e.target.result);
        },
    };
}
</script>
@endpush