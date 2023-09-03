@extends('dashboard.layouts.app_dashboard')
@section('header')
List Discount Product
@endsection
@section('dashboard_main')
<main class="w-full h-full overflow-y-hidden">
    <div x-data="handleListDiscountAndFlashSale()" class="p-4 mt-2">
        <div class="w-full mx-auto bg-white dark:bg-darker shadow-lg rounded-sm">
            <div class="grid grid-cols-2 border-b dark:border-primary-darker">
                {{-- Search Discount Item --}}
                <div class="flex items-center justify-start px-5 py-4">
                    <form action="" method="GET">
                        <div class="flex items-center space-x-3">
                            <x-form.input type="text" name="searchProduct" inputName="search_discount_item" label=""
                                placeholder="Search Discount Item..." />
                            <button type="submit" class="py-1.5 mt-2 px-2 bg-primary rounded text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="px-5 py-4 border-b dark:border-primary-darker flex items-center justify-end space-x-3">
                    <div class="flex items-center space-x-3">
                        <button type="button" data-modal-target="add_flashsale" data-modal-toggle="add_flashsale" x-show="showBtn" x-transition.duration.500ms
                            class="w-fit bg-yellow-500 hover:bg-yellow-600 text-white p-1.5 px-4 rounded cursor-pointer flex items-center space-x-2"
                            id="setFlashSale">
                            <span class="text-xs">SETTING FLASHSALE</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                        </button>
                          <x-dashboard.form-modal actionUrl="{{ URL('dashboard/add-flash-sale') }}" modalId="add_flashsale" modalToggle="add_flashsale">
                            <x-slot:modalHeader>
                                Manage Flash Sale Time
                            </x-slot:modalHeader>
                            <x-slot:inputBox>
                                <div class="what_item_you_pick">
                                    <p class="text-sm mb-2">Item You Pick For Flashsale</p>
                                    <div class="flex items-center flex-wrap space-x-1">
                                        <template x-for="(item, index) in selectedItem" :key="item.item">
                                            <button type="button" class="text-[10px] text-white rounded-full py-1 px-4 mb-2" :class="randomBgColor(index)" x-text="item.item"></button>
                                        </template>
                                    </div>
                                </div>
                                <x-form.input type="text" inputName="name_flashsale" modelBinding="" name="name_flashsale"
                                    label="Flashsale Name" />
                                <x-form.input type="datetime-local" inputName="start_time" modelBinding="startTime" name="start_time"
                                    label="Start Time" />
                                <x-form.input type="datetime-local" inputName="end_time" modelBinding="endTime" name="end_time"
                                    label="End Time" />
                                <input type="hidden" name="item_ids[]" :value="selectedRecordIds">
                                <div class="flex items-center space-x-1">
                                    <p class="text-rose-400">Long Time Flash Sale :</p>
                                    <div class="day flex items-center space-x-1 text-xs">
                                        <p x-text="convertToDayHoursMinutesString()"></p>
                                    </div>
                                </div>
                            </x-slot:inputBox>
                        </x-dashboard.form-modal>
                        <button type="button" data-modal-target="list_flashsale" data-modal-toggle="list_flashsale" x-transition.duration.500ms
                            class="w-fit bg-slate-800 hover:bg-slate-700 text-white p-1.5 px-4 rounded cursor-pointer flex items-center space-x-2"
                            id="listFlashSale">
                            <span class="text-xs">LIST FLASHSALE</span>
                        </button>
                        <x-dashboard.info-modal modalId="list_flashsale" titleModal="LIST FLASHSALE">
                            <x-slot:info>
                                <div class="p-2">
                                    <table class="w-full">
                                      <thead class="text-xs font-semibold uppercase text-white dark:text-light bg-primary hover:bg-primary-dark">
                                         <tr>
                                             <th class="p-1.5">Flashsale Name</th>
                                             <th class="p-1.5">Duration</th>
                                             <th class="p-1.5">Status</th>
                                             <th class="p-1.5">Start Time Flashsale</th>
                                         </tr>
                                      </thead>
                                      <tbody class="text-sm text-primary dark:text-primary-light divide-y divide-gray-100">
                                        @if (count($flash_sales))
                                            @foreach ($flash_sales as $flashsale)
                                                <tr>
                                                    <td class="p-2">
                                                    <p class="font-semibold capitalize">{{ $flashsale->name_flashsale }}</p>
                                                </td>
                                                    <td class="text-center p-2">
                                                        <p x-text="convertToDayHoursMinutesString('{{ $flashsale->start_time }}', '{{ $flashsale->end_time }}')"></p>
                                                    </td>
                                                    <td class="text-center p-2">
                                                    <button class="py-0.5 px-4 rounded {{ $flashsale->is_flash_sale ? 'bg-green-500' : 'bg-rose-500' }} text-white">{{ $flashsale->is_flash_sale ? 'Active' : 'Inactive' }}</button>
                                                    </td>
                                                    <td>
                                                        <div class="text-center">
                                                            <p class="text-xs">{{ $flashsale->start_time }}</p>
                                                        </div>
                                                    </td>
                                                    {{-- <td class="text-center">
                                                        @if ($flashsale->is_flash_sale)
                                                        <form action="{{ URL('dashboard/deactive-flashsale/' . $flashsale->id) }}" method="POST">
                                                            @method('PATCH')
                                                            @csrf
                                                            <button data-popover-target="popover-off" type="submit" class="">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-red-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                                                                </svg>
                                                            </button>
                                                            <div data-popover id="popover-off" role="tooltip" class="absolute z-10 invisible inline-block w-fit text-sm text-white transition-opacity duration-300 bg-rose-300 border border-gray-200 rounded opacity-0 dark:border-gray-600">
                                                                <div class="py-1 px-2">
                                                                    <p>OFF</p>
                                                                </div>
                                                                <div data-popper-arrow></div>
                                                            </div>
                                                        </form>
                                                        @else    
                                                        <form action="{{ URL('dashboard/active-flashsale/' . $flashsale->id) }}" method="POST">
                                                            @method('PATCH')
                                                            @csrf
                                                            <button data-popover-target="popover-on" type="submit" class="">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-500">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9" />
                                                                </svg>
                                                            </button>
                                                            <div data-popover id="popover-on" role="tooltip" class="absolute z-10 invisible inline-block w-fit text-sm text-white transition-opacity duration-300 bg-green-300 border border-gray-200 rounded opacity-0 dark:border-gray-600">
                                                                <div class="py-1 px-2">
                                                                    <p>ON</p>
                                                                </div>
                                                                <div data-popper-arrow></div>
                                                            </div>
                                                        </form>
                                                        @endif
                                                    </td> --}}
                                                </tr>   
                                            @endforeach
                                        @else
                                            <div class="mt-0 mb-3">
                                                <p class="text-md text-center text-rose-400 uppercase dark:text-primary-light">Flashsale hasn't been created yet
                                                </p>
                                            </div>
                                        @endif
                                      </tbody>
                                    </table>
                                </div>
                            </x-slot:info>
                            <x-slot name="footer">
                                
                            </x-slot>
                        </x-dashboard.info-modal>
                    </div>
                </div>
            </div>
            @if ($mess = Session::get('flashsale'))
            <div class="flex justify-center mt-3">
                <div class="w-3/4 h-auto p-2 rounded-md text-center bg-green-400 text-white">
                    <p class="uppercase">{{ $mess }}</p>
                </div>
            </div>
            @elseif($mess = Session::get('flashsale-failed'))
            <div class="flex justify-center mt-3">
                <div class="w-3/4 h-auto p-2 rounded-md text-center bg-rose-400 text-white">
                    <p class="uppercase">{{ $mess }}</p>
                </div>
            </div>
            @elseif($errors->any())
            <div class="flex justify-center mt-3">
              <div class="w-3/4 h-auto p-2 rounded-md text-center bg-rose-400 text-white">
                <p class="font-semibold">ERROR!</p>
                <p class="uppercase">{{ $errors->first() }}</p>
                </div>
            </div>     
            @endif
            <div class="overflow-x-auto p-3">
                <table class="w-full">
                    <thead
                        class="text-xs font-semibold uppercase text-white dark:text-light bg-primary hover:bg-primary-dark">
                        <tr>
                            <th></th>
                            <th class="p-2">
                                <div class="font-semibold text-left">Product Name</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-left">Item Nominal</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-center">Normal Price</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-center">Price After Discount</div>
                            </th>
                            <th class="p-2">
                                <div class="font-semibold text-center">Status Discount</div>
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
                        @if (count($items_discount))
                        @foreach ($items_discount as $item_discount)
                        <tr id="productIds{{ $item_discount->item_id }}">
                            <td class="p-2">
                                <input type="checkbox" autocomplete="off" name="checked_record_ids"
                                    x-model="selectedRecordIds" 
                                    @change="checkSelectedRecord('{{ $item_discount->item_id }}', '{{ $item_discount->item_name }}', '{{ $item_discount->nominal }}')"  
                                    id="selected_items"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 rounded focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2 dark:bg-primary-dark cursor-pointer"
                                    value="{{ $item_discount->item_id }}" />
                            </td>
                            <td class="p-2">
                                <p>{{ $item_discount->product_name }}</p>
                            </td>
                            <td class="p-2 text-left">
                                <p class="text-rose-400">{{ $item_discount->nominal }} {{ $item_discount->item_name }}
                                </p>
                            </td>
                            <td class="p-2 text-center">
                                <p>Rp. {{ Cash($item_discount->price) }}</p>
                            </td>
                            <td class="p-2 text-center">
                                <p>Rp. {{ Cash($item_discount->price_after_discount) }}</p>
                            </td>
                            <td class="p-2">
                                <div class="text-center font-medium text-green-500">
                                    <button
                                        class="py-1.5 px-6 rounded {{ $item_discount->status_discount ? 'bg-green-500' : 'bg-rose-500' }} text-white font-bold">{{ $item_discount->status_discount ? 'Active' : 'Inactive' }}</button>
                                </div>
                            </td>
                            <td class="p-2">
                                <div class="text-left font-medium text-green-500">
                                    {{ DateFormat($item_discount->created_at, 'd-F-Y') }}
                                </div>
                            </td>
                            <td class="p-2">
                                <div class="text-center">              
                                <button id="settingDropdown{{ $item_discount->id }}" data-dropdown-toggle="dropdown{{ $item_discount->id }}" class="border border-solid border-slate-400 rounded p-1.5 shadow-lg" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                                <div id="dropdown{{ $item_discount->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="settingDropdown{{ $item_discount->id }}">
                                        <li>
                                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <button type="button" data-modal-target="delete_discount{{ $item_discount->id }}" data-modal-toggle="delete_discount{{ $item_discount->id }}"
                                                    class="w-full py-1 px-2 rounded bg-red-500 hover:bg-red-300 transition-colors duration-150 text-white text-[12px] flex items-center justify-between">
                                                    Delete Discount
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                @if ($item_discount->status_discount)
                                                    <form action="{{ URL('dashboard/deactive-discount/' . $item_discount->item_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="w-full py-1 px-2 rounded border border-solid border-rose-500 hover:bg-rose-300 hover:text-white transition-colors duration-150 text-rose-500 text-[10px] text-center">
                                                        Deactive Discount
                                                    </button>
                                                    </form>
                                                @else
                                                    <form
                                                        action="{{ URL('dashboard/activate-discount/' . $item_discount->item_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit"
                                                            class="w-full py-1 px-2 rounded border border-solid border-green-500 hover:bg-green-300 hover:text-white transition-colors duration-150 text-green-500 text-[10px] text-center">
                                                            Activated Discount
                                                        </button>
                                                    </form>
                                                @endif
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                    <x-dashboard.form-modal actionUrl="{{ URL('dashboard/delete-discount/' . $item_discount->id) }}" modalId="delete_discount{{ $item_discount->id }}" modalToggle="delete_discount{{ $item_discount->id }}">
                                        <x-slot:modalHeader>
                                            Delete Discount
                                        </x-slot:modalHeader>
                                        <x-slot:inputBox>
                                          @method('PATCH')
                                            <div class="">
                                              <p>Are You Sure Want Delete Discount For Items </p>
                                              <p class="text-rose-400 text-xl mt-1">{{ $item_discount->nominal }} - {{ $item_discount->item_name }}</p>
                                            </div>
                                        </x-slot:inputBox>
                                    </x-dashboard.form-modal>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <div class="mt-2 mb-3">
                            <p class="text-2xl text-center text-rose-400 uppercase dark:text-primary-light">Discount for product hasn't been
                                created yet
                            </p>
                        </div>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Pagination Table --}}
        <div class="mb-2 p-4">
            {{ $items_discount->links('vendor.pagination.simple-tailwind') }}
        </div>
    </div>
</main>
@push('dashboard-js')
<script>
    function handleListDiscountAndFlashSale() {
        return {
            showBtn: false, 
            selectedRecordIds: [],
            selectedItem: [],
            startTime: '',
            endTime: '',
            colorClasses: [
                'bg-rose-400',
                'bg-blue-400',
                'bg-green-400',
                'bg-yellow-400',
                'bg-purple-400',
                'bg-zinc-400',
                'bg-slate-400'
            ],

            init() {
            },

            checkSelectedRecord(item_id, item_name, item_nominal) {
                const selectedRecordIndex = this.selectedRecordIds.findIndex(itemId => itemId === item_id)
          
                if (selectedRecordIndex !== -1) {
                    this.selectedItem.push({
                        item: item_nominal + " " + item_name,
                    });
                } else {
                    const selectedItemIndex = this.selectedItem.findIndex(item => item.item === item_nominal + " " + item_name)
                    this.selectedItem.splice(selectedItemIndex, 1)
                }
                this.updateBtnVisibillity()
            },

            updateBtnVisibillity() {
                this.showBtn = this.selectedRecordIds.length > 0
            },

            randomBgColor(index) {
                const randomIndex = Math.floor(Math.random() * this.colorClasses.length);
                return this.colorClasses[randomIndex];
            },

            convertToDayHoursMinutesString(startTime, endTime) {
                let startDate = null
                let endDate   = null
                
                if (!startTime || !endTime) {
                    if (!this.startTime || !this.endTime) {
                        return "0 Days, 0 Hours, 0 Minutes";
                    }
                    startDate = new Date(this.startTime);
                    endDate = new Date(this.endTime);
                } else {
                    startDate = new Date(startTime);
                    endDate = new Date(endTime);
                }

                const timeDiff = endDate - startDate;
                const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));

                return `${days} Days, ${hours} Hours, ${minutes} Minutes`;
            }
        }
    }
</script>
@endpush
@endsection
