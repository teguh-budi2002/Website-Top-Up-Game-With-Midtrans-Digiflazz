@extends('dashboard.layouts.app_dashboard')
@section('header') 
Manage Discount Product
@endsection
@section('dashboard_main')
<main class="w-full h-full">
    @if ($mess = Session::get('success-add-discount'))
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
    @elseif ($mess = Session::get('error-discount'))
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
          <div class="w-10/12 h-auto p-1.5 bg-white shadow-md rounded mx-auto">
              <div
                  class="available_payment_fee border-2 border-white dark:border-primary-100 border-solid py-2 px-2">
                  <p class="uppercase bg-primary-100 dark:bg-primary-darker text-gray-400 dark:text-white w-fit p-1 px-3 rounded-md font-semibold">Discount Item</p>
                  <div class="mt-4">
                     <a href="{{ URL('dashboard/list-discount') }}" class="py-2 px-2 rounded bg-primary-light dark:bg-primary-dark text-white flex items-center justify-between w-56">
                      <span class="">List Discount Item</span>
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                      </svg>
                    </a>
                  </div>
              </div>
          </div>
            <div class="w-10/12 h-auto p-3 bg-white shadow-md rounded mx-auto mt-5" x-data="handleDiscountProduct()">
                <form action="{{ URL('dashboard/add-discount-to-product') }}" method="POST">
                  @csrf
                  <div class="name_product space-y-2">
                    <label for="product" class="block dark:text-gray-900">Product</label>
                    <select name="product_id" class="w-64 capitalize dark:text-black" id="product" x-model="selectedProduct" @change="getAllItems">
                      <option value="" selected disabled>Choice Product</option>
                        <template x-for="product in products" :key="product.id">
                            <option :value="product.id" x-text="product.product_name"></option>
                        </template>  
                    </select>
                  </div>
                  <div class="name_item space-y-2 mt-3">
                    <label for="item_product" class="block dark:text-gray-900">Item Product</label>
                    <select name="item_id" class="w-64 capitalize dark:text-black"x-model="selectedItem" @change="updateNormalPrice" id="item_product">
                      <option value="" selected disabled>Choice Item</option>
                      <template x-if="items.length">
                        <template x-for="item in items" :key="item.id">
                          <option :value="item.id" :data-price="item.price" x-text="`${item.nominal} - ${item.item_name}`"></option>
                        </template>
                      </template>
                    </select>
                  </div>
                  <div class="display_price mt-3">
                    <div class="normal_price flex items-center space-x-2">
                      <p>Harga Normal: </p>
                      <p class="font-bold" x-text="normalPrice"></p>
                    </div>
                    <div class="discount_price flex items-center space-x-2 mt-1">
                      <p>Harga Setelah Diskon: </p>
                      <p class="font-bold" :class="{'text-rose-500' : isDiscountOverpriced === true}" x-text="discountPrice.toLocaleString('id-ID', {style: 'currency', currency: 'IDR'})"></p>
                    </div>
                  </div>
                  <div class="input__group mt-3">
                    <div class="input__flat__discount" x-show="discountType === 'discount_flat'">
                      <label for="flat_fee" class="capitalize dark:text-gray-900">discount flat</label>
                      <div class="flex items-center space-x-2">
                        <x-form.input type="number" inputName="discount_flat" name="discount_flat" modelBinding="dataForm.discount_flat" inputBinding="handleDiscountPrice" />
                        <p class="dark:text-gray-900">Rp. <span x-text="dataForm.discount_flat"></span></p>
                      </div>
                    </div>
                    <div class="input__fixed__discount" x-show="discountType === 'discount_fixed'">
                      <label for="fix_fee" class="capitalize dark:text-gray-900">discount fixed</label>
                      <div class="flex items-center space-x-2">
                        <x-form.input type="number" inputName="discount_fixed" modelBinding="dataForm.discount_fixed" inputBinding="handleDiscountPrice" name="discount_fixed" />
                        <p class="text-xl font-semibold dark:text-gray-900"><span x-text="dataForm.discount_fixed"></span> %</p>
                      </div>
                    </div>
                  </div>
                  <div class="type__discount text-xs flex items-center space-x-3 mt-4">
                    <div class="is_flat_fee flex items-center space-x-2">
                      <label for="is_flat_fee" class="dark:text-gray-900">Discount Flat</label>
                      <input type="radio" name="type_discount" @click="discountType = 'discount_flat'" value="discount_flat" class="w-3 h-3 rounded cursor-pointer" id="is_flat_fee">
                    </div>
                    <div class="is_fix_discount">
                      <label for="is_fix_discount" class="dark:text-gray-900">Discount Fixed</label>
                      <input type="radio" name="type_discount" @click="discountType = 'discount_fixed';" value="discount_fixed" class="w-3 h-3 rounded cursor-pointer" id="is_fix_discount">
                    </div>
                  </div>
                  <input type="hidden" name="price_after_discount" :value="discountPrice" id="">
                  <div class="btn_submit mt-3">
                    <button type="submit" class="py-2 px-8 rounded bg-primary-light dark:bg-primary-dark text-white">Add Discount</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</main>
@push('dashboard-js')
<script>
    function handleDiscountProduct() {
      return {
        discountType: '',
        selectedProduct: '',
        selectedItem: '',
        normalPrice: '',
        discountPrice: '',
        isDiscountOverpriced: false,
        dataForm: {
          discount_flat: null,
          discount_fixed: null
        },
        products: [],
        items: [],

        init() {
          this.getAllProducts()
        },

        getAllProducts() {
          axios.get('/api/get-token').then(res => {
            const token = res.data.data
            axios.get("/api/get-products", {
              'headers' : {
                'X-Custom-Token': `${token}`
              }
            }).then(res => {
              if(res.status == 200) {
                this.products = res.data.data
              }
            }).catch(err => {
                console.log(err)
            })
          })
        },

        getAllItems() {
          let reqBody = {
            product_id: this.selectedProduct
          }

          axios.get('/api/get-token').then(res => {
            const token = res.data.data
            axios.post("/api/get-items-by-product", reqBody ,
            {
              headers : {
                'X-Custom-Token': `${token}`
              }
            }).then(res => {
              if(res.status == 200) {
                this.items = res.data.data
              }
            }).catch(err => {
                console.log(err)
            })
          })
        },

        updateNormalPrice() {
            const selectedOption = this.$el.querySelector('select[name="item_id"] option:checked');
            if (selectedOption) {
                let getPrice = parseInt(selectedOption.getAttribute('data-price'));
                this.normalPrice = getPrice.toLocaleString('id-ID', {
                  style: 'currency',
                  currency: 'IDR'
                })
            }
        },

        convertPriceIntoInteger() {
                  const strPrice = this.normalPrice
                  const replaceStr = strPrice ? strPrice.replace(/[^0-9]/g, "") : null
                  const normalPrice = parseInt(replaceStr)
                  return normalPrice / 100
        },

        handleDiscountPrice() {
          let discountType = this.discountType
          let discountFlat = parseInt(this.dataForm.discount_flat)
          let discountFixed = parseInt(this.dataForm.discount_fixed)
          let normalPrice = this.convertPriceIntoInteger()

          if (discountType === 'discount_fixed') {
            let discountPercent = discountFixed / 100;
            let discountFixedAmount = normalPrice * discountPercent;
            
            if(isNaN(discountFixedAmount)) {
              this.isDiscountOverpriced = false
              this.discountPrice = "Rp. 0"
            } else if (discountFixedAmount > normalPrice) {
              this.isDiscountOverpriced = true
              this.discountPrice =  "Diskon Melebihi Dari Harga Normal"
            } else {
              this.isDiscountOverpriced = false
              let totalDiscount = normalPrice - discountFixedAmount
              this.discountPrice =  totalDiscount
            }
          } else if(discountType === 'discount_flat') {
            let discountFlatAmount = normalPrice - discountFlat

            if (isNaN(discountFlatAmount)) {
              this.isDiscountOverpriced = false
              this.discountPrice = "Rp. 0"
            } else if (discountFlat > normalPrice) {
              this.isDiscountOverpriced = true
              this.discountPrice = "Diskon Melebihi Dari Harga Normal"
            } else {
              this.isDiscountOverpriced = false
              this.discountPrice = discountFlatAmount
            }
          }
        }
      }
    }
</script>
@endpush
@endsection