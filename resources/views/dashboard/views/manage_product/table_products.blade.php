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
            <span>SELECTED PRODUCTS</span>
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

    <div class="overflow-x-auto p-3">
      <table class="w-full">
        <thead class="text-xs font-semibold uppercase text-white dark:text-light bg-primary hover:bg-primary-dark">
          <tr>
            <th></th>
            <th class="p-2">
              <div class="font-semibold text-left">Product Name</div>
            </th>
            <th class="p-2">
              <div class="font-semibold text-center">Items</div>
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
                        <table class="w-full">
                          <thead class="border-b dark:border-primary">
                            <tr>
                              <th class="p-2">ITEM NAME</th>
                              <th class="p-2">ITEM NOMINAL</th>
                              <th class="p-2">HARGA</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($product->items as $item)
                              <tr>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->nominal }}</td>
                                <td>Rp. {{ Cash($item->price, 2) }}</td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      @else
                        <p class="text-2xl uppercase dark:text-primary-light">Produk
                          <span class="text-red-400">{{ $product->product_name }}</span> Belum Mempunyai
                          Item Apapun
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
                <td class="p-2">
                  <div class="text-left font-medium text-green-500">
                    {{ DateFormat($product->created_at, 'd-F-Y') }}
                  </div>
                </td>
                <td class="p-2">
                  <div class="flex justify-center">
                    <button data-popover-target="popover-add-items" data-modal-target="add_item_on_product"
                      data-modal-toggle="add_item_on_product" data-popover-placement="bottom" type="button">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8 hover:text-blue-600 rounded-full hover:bg-gray-100 p-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
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
                      <svg class="w-8 h-8 hover:text-blue-600 rounded-full hover:bg-gray-100 p-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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
                        <p class="dark:text-white text-lg">Dengan menghapus produk, Maka item pada
                          produk akan ikut terhapus!</p>
                      </x-slot:info>
                      <x-slot name="footer">
                        <form action="{{ URL('dashboard/product/' . $product->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit"
                            class="py-2.5 px-6 bg-red-600 hover:bg-red-400 transition rounded text-white">Ya,
                            Hapus</button>
                        </form>
                      </x-slot>
                    </x-dashboard.info-modal>
                  </div>
                  {{-- Form Modal ADD ITEMS Component --}}
                  <x-dashboard.form-modal actionUrl="dashboard/item/store" modalId="add_item_on_product"
                    modalToggle="add_item_on_product">
                    <x-slot:modalHeader>
                      Add Items On Product
                    </x-slot:modalHeader>
                    <x-slot:inputBox>
                      <x-form.input type="text" inputName="item_name" name="item_name"
                        label="Masukkan Nama Item" />
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
              <p class="text-2xl text-center uppercase dark:text-primary-light">The product hasn't been created yet</p>
            </div>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
