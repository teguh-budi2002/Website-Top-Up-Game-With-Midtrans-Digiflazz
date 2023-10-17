<div x-data="handleTableProducts()"  class="w-full h-full overflow-hidden p-4 mt-2">
    <div class="w-full h-fit bg-white dark:bg-darker shadow-lg rounded-sm">
        <div class="grid md:grid-cols-2 grid-cols-1 border-b dark:border-primary-darker">

            {{-- Search Product --}}
            @include('dashboard.views.manage_product.search_product')

            <div class="px-5 py-4 border-b dark:border-primary-darker md:flex md:items-center md:justify-end md:space-x-3 space-y-2">
                <div>
                    <button x-show="showBtn" x-transition.duration.500ms
                        class="w-fit bg-red-500 hover:bg-red-600 text-white md:p-1.5 md:px-4 p-1 px-2 md:mt-2 mt-0 rounded cursor-pointer"
                        id="btnDeleteAllRecords" type="submit">
                        <span class="md:text-md text-sm uppercase">deleted selected products</span>
                    </button>
                </div>
                <div data-modal-target="add_product" data-modal-toggle="add_product">
                    <button
                        class="w-fit bg-primary hover:bg-primary-dark dark:bg-primary-light dark:hover:bg-primary-dark text-white flex items-center md:p-1.5 md:px-4 p-1 px-2 rounded cursor-pointer"
                        type="button">
                        <span class="md:text-md text-sm uppercase">add product</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="md:w-8 md:h-8 w-4 h-4 md:p-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
            </div>
            
        </div>
        <div class="px-5 py-4">
            @foreach ($categories as $category)
                <a href="?category_id={{ $category->id }}" class="bg-primary-100 rounded-md w-fit h-auto p-2 text-xs font-semibold text-primary">{{ $category->name_category }}</a>
            @endforeach
        </div>

        {{-- Modal ADD PRODUCT Component --}}
        <x-dashboard.form-modal actionUrl="dashboard/product" enctype="multipart/form-data" modalId="add_product" modalToggle="add_product">
            <x-slot:modalHeader>
                Add Product
            </x-slot:modalHeader>
            <x-slot:inputBox>
                <x-form.input type="text" inputName="product_name" name="name_game" label="Insert Name of Product" />
                <label for="categoryProduct" class="block mt-3 text-slate-600 dark:text-primary-dark text-sm">
                    Category Product
                </label>
                <select name="category_id" class="p-2" id="categoryProduct" style="box-shadow: none;padding: 8px">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name_category }}</option>
                    @endforeach
                </select>
                <div class="image_for_product">
                    <label for="custom_bg_product" class="block mt-3 text-slate-600 dark:text-primary-dark text-sm">Add Photo Into Product</label>
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
                            <div class="font-semibold text-left">Category Product</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Items</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Payment Method</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Published</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-left">Created At</div>
                        </th>
                        <th class="p-2">
                            <div class="font-semibold text-center">Action</div>
                        </th>
                    </tr>
                </thead>

                <tbody class="text-sm text-primary dark:text-primary-light divide-y divide-gray-100 dark:divide-primary">
                    @if (count($products))
                    @foreach ($products as $product)
                    <tr>
                        <td class="p-2">
                            <input type="checkbox" autocomplete="off" name="checked_record_ids" x-model="selectedRecord" 
                                id="selected_items"
                                @change="updateBtnVisibillity()"
                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2 dark:bg-primary-dark cursor-pointer"
                                value="{{ $product->id }}" />
                        </td>
                        <td class="p-2">
                            @if ($product->is_testing)
                                <img src="{{ asset($product->img_url) }}" class="w-10 h-10 rounded mx-auto" alt="">
                            @else
                                <img class="w-10 h-10 rounded mx-auto" src="{{ asset('/storage/product/' . $product->product_name . '/' . $product->img_url) }}" alt="image_{{ $product->product_name }}">
                            @endif
                        </td>
                        <td class="p-2">
                            <div class="font-medium">
                                {{ $product->product_name }}
                            </div>
                        </td>
                        <td class="p-2">
                            <div>
                                <button type="button" class="w-fit h-auto p-1 bg-primary-50 font-semibold text-primary text-xs rounded-md">
                                    {{ $product->category->name_category }}
                                </button>
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
                            <div class="text-center">
                                <button class="py-1 px-6 rounded {{ $product->published ? 'bg-green-500' : 'bg-rose-500' }} font-medium text-white">{{ $product->published ? 'PUBLISHED' : 'UNPUBLISHED' }}</button>
                            </div>
                        </td>
                        <td class="p-2">
                            <div class="text-left font-medium text-green-500">
                                {{ DateFormat($product->created_at, 'd-F-Y') }}
                            </div>
                        </td>
                        <td class="p-2">
                            <div class="flex justify-center items-center space-x-2">
                                <button data-popover-target="popover-add-items"
                                    data-modal-target="add_item_on_product{{ $product->id }}"
                                    data-modal-toggle="add_item_on_product{{ $product->id }}"
                                    data-popover-placement="bottom" type="button">
                                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                  </svg>
                                </button>
                                <div data-popover id="popover-add-items" role="tooltip"
                                    class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border dark:border-primary-dark rounded opacity-0 dark:text-white dark:bg-primary-dark">
                                    <div class="px-3 py-2 text-center">
                                        <p>Add Items On Product</p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>
                                @if ($product->published)
                                  <form action="{{ URL("dashboard/unpublished-product/" . $product->id) }}" method="POST">
                                      @csrf
                                      @method('PATCH')
                                      <button data-popover-target="popover-bottom-unpublished"
                                          data-popover-placement="bottom" type="submit"
                                          class="mt-1.5 relative">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-rose-500 -rotate-45">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                          </svg>
                                          <i class="fa-solid fa-ban fa-2xl absolute inset-0 top-2.5 -left-1 opacity-70 text-rose-400"></i>
                                      </button>
                                      <div data-popover id="popover-bottom-unpublished" role="tooltip"
                                          class="absolute z-10 invisible inline-block w-fit text-xs text-white transition-opacity duration-300 bg-rose-400 rounded shadow-sm opacity-0">
                                          <div class="px-2 py-1">
                                              <p>Unpublish Now</p>
                                          </div>
                                          <div data-popper-arrow></div>
                                      </div>
                                  </form>
                                @else
                                  <form action="{{ URL("dashboard/published-product/" . $product->id) }}" method="POST">
                                      @csrf
                                      @method('PATCH')
                                      <button data-popover-target="popover-bottom-published"
                                          data-popover-placement="bottom" type="submit"
                                          class="mt-1.5">
                                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                          </svg>
                                      </button>
                                      <div data-popover id="popover-bottom-published" role="tooltip"
                                          class="absolute z-10 invisible inline-block w-fit text-xs text-white transition-opacity duration-300 bg-green-400 rounded shadow-sm opacity-0">
                                          <div class="px-2 py-1">
                                              <p>Publish Now</p>
                                          </div>
                                          <div data-popper-arrow></div>
                                      </div>
                                  </form>
                                @endif
                                <button type="button" data-modal-target="deleteProductModal{{ $product->id }}"
                                    data-modal-toggle="deleteProductModal{{ $product->id }}">
                                    <svg class="w-5 h-5 text-rose-400 hover:text-rose-600"
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
                                            label="Insert Name of Item" />
                                        @endforeach
                                    @else
                                        <x-form.input type="text" inputName="item_name" name="item_name"
                                            label="Insert Name of Item" />
                                    @endif
                                    <x-form.input type="text" inputName="code_item" name="code_item"
                                        label="Insert Code Item" />
                                    <x-form.input type="text" inputName="nominal" name="nominal"
                                        label="Insert Nominal Item" />
                                    <x-form.input type="number" inputName="price" name="price" label="Set Item Price" />
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                </x-slot:inputBox>
                            </x-dashboard.form-modal>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <div class="mt-2 mb-3">
                        <p class="text-2xl text-rose-400 text-center uppercase dark:text-primary-light">The product hasn't been
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
    new SlimSelect({
        select: '#categoryProduct'
    })

    function handleTableProducts() {
        return {
            showBtn: false, 
            selectedRecord: [],
            
            updateBtnVisibillity() {
                this.showBtn = this.selectedRecord.length > 0
            },
        }
    }
</script>
@endpush