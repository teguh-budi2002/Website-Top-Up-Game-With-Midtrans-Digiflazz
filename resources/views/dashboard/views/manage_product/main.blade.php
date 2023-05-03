@extends('dashboard.layouts.app_dashboard')
@section('dashboard_main')
<main class="overflow-y-hidden">
    <!-- Content header -->
    <div class="flex items-center justify-between px-4 py-4 border-b lg:py-6 dark:border-primary-darker">
        <h1 class="text-2xl font-semibold">Manage Games Product</h1>
        <a href="https://github.com/Kamona-WD/kwd-dashboard" target="_blank"
            class="px-4 py-2 text-sm text-white rounded-md bg-primary hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
            View on github
        </a>
    </div>

    {{-- Alert Notif --}}
    @if ($errors->any())
    <div class="p-2 px-16 mt-2">
        <x-alert bg-color="bg-red-400">
            <x-slot:alertHeader>
                <p class="text-3xl uppercase text-red-600">error!</p>
            </x-slot:alertHeader>
            <x-slot:textMess>
                @foreach ($errors->all() as $err)
                <ul>
                    <li class="text-left">
                        - {{$err}}
                    </li>
                </ul>
                @endforeach
            </x-slot:textMess>
        </x-alert>
    </div>
    @endif

    @if ($mess = Session::get('create_success'))
    <div class="p-2 px-16 mt-2">
        <x-alert bg-color="bg-green-400">
            <x-slot:alertHeader>
                <p class="text-2xl uppercase text-green-600">success!</p>
            </x-slot:alertHeader>
            <x-slot:textMess>
                {{ $mess }}
            </x-slot:textMess>
        </x-alert>
    </div>
    @elseif ($mess = Session::get('delete_success'))
    <div class="p-2 px-16 mt-2">
        <x-alert bg-color="bg-red-400">
            <x-slot:alertHeader>
                <p class="text-2xl uppercase text-red-600">deleted!</p>
            </x-slot:alertHeader>
            <x-slot:textMess>
                {{ $mess }}
            </x-slot:textMess>
        </x-alert>
    </div>
    @endif

    {{-- Table Products --}}
    @include('dashboard.views.manage_product.table_products', ['products' => $products])

    {{-- Pagination Table --}}
    <div class="mb-2 p-4">
      {{ $products->links('vendor.pagination.simple-tailwind') }}
    </div>

    {{-- Modal ADD PRODUCT Component --}}
    <x-dashboard.form-modal actionUrl="dashboard/product" modalId="add_product" modalToggle="add_product">
        <x-slot:modalHeader>
            Add Product
        </x-slot:modalHeader>
        <x-slot:inputBox>
            <x-form.input type="text" inputName="product_name" name="name_game" label="Masukkan Nama Product" />
        </x-slot:inputBox>
    </x-dashboard.form-modal>

    @push('dashboard-js')
    <script>
        $(function (e) {
            const btnDeleteRecords = $('#btnDeleteAllRecords')
            let selectedItems = $('#selected_items')

            btnDeleteRecords.click(function (e) {
                e.preventDefault()
                let allItems = []

                $('input:checkbox[name=checked_record_ids]:checked').each(function (el) {
                    allItems.push($(this).val())
                })

                // Call Api Delete Many Records
                $.ajax({
                    url: "delete-checked-products",
                    method: "DELETE",
                    data: {
                        productIds: allItems,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        $.each(allItems, function (key, id) {
                            console.log(id)
                            $('#productIds' + id).remove()
                        })
                    }
                })
            })
        })

    </script>
    @endpush
</main>
@endsection
