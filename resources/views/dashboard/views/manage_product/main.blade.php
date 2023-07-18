@extends('dashboard.layouts.app_dashboard')
@section('header') 
Manage Games Product
@endsection
@section('dashboard_main')
<main class="w-full h-full overflow-y-hidden">

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
