@extends('dashboard.layouts.app_dashboard')
@section('header') 
Manage Games Product
@endsection
@section('dashboard_main')
<main class="w-full h-full">

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
    @elseif ($mess = Session::get('update_success'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-green-500 text-center bg-green-300">{{ $mess }}</div>
    </div>
    @elseif ($mess = Session::get('product-failed'))
    <div class="mx-16 mt-4">
        <div class="p-2 rounded text-red-500 text-center bg-red-300">{{ $mess }}</div>
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
</main>
@endsection
