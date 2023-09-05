@extends('dashboard.layouts.app_dashboard')
@section('header')
Manage Payment Fee
@endsection
@section('dashboard_main')
  <main class="w-full h-full">
    @if ($mess = Session::get('success-add-fee'))
    <div class="p-2 px-16 mt-5">
        <x-alert bg-color="bg-green-400">
            <x-slot:alertHeader>
                <p class="text-2xl uppercase text-green-600">success!</p>
            </x-slot:alertHeader>
            <x-slot:textMess>
                {{ $mess }}
            </x-slot:textMess>
        </x-alert>
    </div>
    @elseif ($mess = Session::get('failed-add-fee'))
    <div class="p-2 px-16 mt-5">
        <x-alert bg-color="bg-red-400">
            <x-slot:alertHeader>
                <p class="text-2xl uppercase text-red-600">error!</p>
            </x-slot:alertHeader>
            <x-slot:textMess>
                {{ $mess }}
            </x-slot:textMess>
        </x-alert>
    </div>
    @elseif ($errors->any())
    <div class="p-2 px-16 mt-5">
        <x-alert bg-color="bg-red-400">
            <x-slot:alertHeader>
                <p class="text-2xl uppercase text-red-600">error!</p>
            </x-slot:alertHeader>
            @foreach ($errors->all() as $err)
            <x-slot:textMess>
                {{ $err }}
            </x-slot:textMess>
            @endforeach
        </x-alert>
    </div>
    @endif
    <div class="box__container mt-5">
        <div class="">
          @if ($payment_fees->count())
          <div class="w-10/12 h-auto p-1.5 bg-white shadow-md rounded mx-auto">
              <div
                  class="available_payment_fee border-2 border-white dark:border-primary-100 border-solid py-2 px-2">
                  <p
                      class="uppercase bg-primary-100 dark:bg-primary-darker text-gray-400 dark:text-white w-fit p-1 px-3 rounded-md font-semibold">
                      Available Payment Fee</p>
                  <div class="mt-4">
                      @foreach ($payment_fees as $fee)
                      <div class="grid grid-cols-5 gap-5 space-y-2">
                        <div class="col-span-1">
                          <img src="{{ asset('/img/' . $fee->payment->img_static) }}" class="w-auto h-6" alt="{{ $fee->payment->payment_name }}">
                        </div>
                        <div class="col-span-2">
                          @if (!is_null($fee->fee_fixed))
                            <p class="font-semibold text-gray-400">{{ $fee->fee_fixed }} %</p>
                          @endif
                          @if (!is_null($fee->fee_flat))
                            <p class="font-semibold text-gray-400">Rp. {{ number_format($fee->fee_flat, 2) }}</p>
                          @endif
                        </div>
                      </div>
                      @endforeach
                  </div>
              </div>
          </div>
          @endif
            <div class="w-10/12 h-auto p-3 bg-white shadow-md rounded mx-auto mt-5" x-data="handlePaymentFee">
                <form action="{{ URL('/dashboard/add-payment-fee') }}" method="POST">
                  @csrf
                  <div class="all__payments space-y-2">
                    <label for="payment_methods" class="block dark:text-gray-900">All Payment</label>
                    <select name="payment_id" class="w-64 capitalize dark:text-black" id="payment_methods">
                      @foreach ($payment_methods as $payment)
                        <option value="{{ $payment->id }}">{{ $payment->payment_name }}</option>  
                      @endforeach
                    </select>
                  </div>
                  <div class="input__group mt-3">
                    <div class="input__flat__fee" x-show="typeFee === 'flat_fee'">
                      <label for="flat_fee" class="capitalize dark:text-gray-900">flat fee</label>
                      <div class="flex items-center space-x-2">
                        <x-form.input type="number" inputName="fee_flat" name="flat_fee" modelBinding="dataForm.fee_flat" />
                        <p class="dark:text-gray-900">Rp. <span x-text="dataForm.fee_flat"></span></p>
                      </div>
                    </div>
                    <div class="input__fixed__fee" x-show="typeFee === 'fix_fee'">
                      <label for="fix_fee" class="capitalize dark:text-gray-900">fixed fee</label>
                      <div class="flex items-center space-x-2">
                        <x-form.input inputName="fee_fixed" modelBinding="dataForm.fee_fixed" name="fix_fee" />
                        <p class="text-xl font-semibold dark:text-gray-900"><span x-text="dataForm.fee_fixed"></span> %</p>
                      </div>
                    </div>
                  </div>
                  <div class="type__fee text-xs flex items-center space-x-3 mt-4">
                    <div class="is_flat_fee flex items-center space-x-2">
                      <label for="is_flat_fee" class="dark:text-gray-900">Flat Fee</label>
                      <input type="radio" name="type_fee" @click="typeFee = 'flat_fee'" value="fee_flat" class="w-3 h-3 rounded cursor-pointer" id="is_flat_fee">
                    </div>
                    <div class="is_fix_fee">
                      <label for="is_fix_fee" class="dark:text-gray-900">Fix Fee</label>
                      <input type="radio" name="type_fee" @click="typeFee = 'fix_fee'" value="fee_fixed" class="w-3 h-3 rounded cursor-pointer" id="is_fix_fee">
                    </div>
                  </div>
                  <div class="btn_submit mt-3">
                    <button type="submit" class="py-2 px-8 rounded bg-primary-light dark:bg-primary-dark text-white">Add Fee</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</main>
@push('dashboard-js')
<script>
    function handlePaymentFee() {
      return {
        typeFee: '',
        dataForm: {
          fee_flat: null,
          fee_fixed: null
        }
      }
    }
</script>
@endpush
@endsection