@extends('dashboard.layouts.app_dashboard')
@section('header')
Manage Users
@endsection
@section('dashboard_main')
<main class="w-full h-full">

    {{-- Table Products --}}
    @include('dashboard.views.manage_user.table_users')

    {{-- Pagination Table --}}
    <div class="mb-2 p-4">
      {{ $users->links('vendor.pagination.simple-tailwind') }}
    </div>
</main>
@endsection