<div class="items__box mt-3" x-data="handleGetProducts()">
  <div class="flex justify-center" x-show="isLoading">
    <div class="custom_loader"></div>
  </div>
  <div class="flex justify-center">
    <template x-if="products.length > 0">
      <div class="grid sm:grid-cols-5 grid-cols-2 gap-3" x-intersect.threshold.50="showImg = true">
        <template x-for="product in products" :key="product.id">
          <div class="item_box group w-full bg-primary-slate rounded-md text-center" x-show="showImg"
          x-transition:enter="transition ease-out duration-1500"
          x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100">
          <a :href="'order/' + product.slug" class="no-underline">
            <img :src="`/storage/product/${product.product_name}/${product.img_url}`" class="w-full rounded-t-md" alt="">
            <span
            class="block pb-5 pt-3 capitalize text-primary-cyan group-hover:text-primary-cyan-light transition-colors duration-200"
            x-text="product.product_name"></span>
          </a>
        </div>
      </template>
    </div>
  </template>
  <template x-if="products.length == 0 && isLoading == false">
    <div class="w-full h-auto p-2 border border-solid mb-10 border-slate-400 bg-white/20">
      <p class="text-red-400 text-2xl text-center">Produk Masih Belum Di Buat Oleh Pihak Toko.</p>
    </div>
  </template>
</div>
</div>
<script>
  function handleGetProducts() {
    return {
      products: [],
      showImg: false,
      isLoading: false,
      
      init() {
        this.getProducts()
      },
      
      getProducts() {
        this.isLoading = true
        axios.get('/api/get-token').then(res => {
          const token = res.data.data

          axios.get('/api/get-products', {
            headers: {
              'X-Custom-Token': `${token}`
            }
          })
          .then(res => {
            const dataProducts = res.data.data
            this.products.push(...dataProducts)
          })
        })
        this.isLoading = false
      },
    }
  }
  
</script>
