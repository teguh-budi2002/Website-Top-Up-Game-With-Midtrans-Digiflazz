<div class="items__box mt-5" x-data="handleGetProducts()">
  <div class="flex justify-center" x-show="isLoading">
    <div class="custom_loader"></div>
  </div>
  <div class="flex justify-center">
    <div class="w-full h-full">
      <template x-if="favoriteProducts.length > 0">
      <div class="grid md:grid-cols-3 grid-cols-1 gap-3">
        <template x-for="product in favoriteProducts" :key="product.id">
        <a :href="'order/' + product.slug"  class="bg-gradient-to-r from-violet-50 to-violet-50 dark:bg-gradient-to-l dark:from-slate-700 dark:via-slate-800 via-90% dark:to-slate-900 w-full h-auto p-2 border-2 border-solid border-violet-500 dark:border-primary-cyan-light rounded-md flex items-center space-x-4">
          <div class="img_product_fav md:w-20 md:h-20 w-10 h-10">
            <template x-if="!product.is_testing">
              <img :src="`/storage/product/${product.product_name}/${product.img_url}`" class="w-full h-auto rounded-md object-cover" :alt="`image favorite product${product.product_name}`">
            </template>
            <template x-if="product.is_testing">
               <img :src="product.img_url" class="w-full h-auto rounded-md object-cover" alt="logo product [DEV]">
            </template>
          </div>
          <div class="description">
            <p class="font-semibold text-violet-700 dark:text-slate-300 md:text-lg text-sm" x-text="product.product_name + '&#128293;'"></p>
            <div class="flex items-center space-x-2 mt-1">
              <p class="text-xs text-violet-400 dark:text-primary-cyan-light">Best Game</p>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 p-0.5 rounded-full bg-green-500 text-white font-semibold">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
              </svg>
            </div>
          </div>
        </a>
        </template>
      </div>
      </template>
    </div>
</div>
</div>
@push('js-custom')
<script>
function handleGetProducts(){return{favoriteProducts:[],showImg:!1,isLoading:!1,init(){this.getProducts()},getProducts(){this.isLoading=!0,axios.get("/api/get-products",{headers:{"X-Custom-Token":"{{ $accessApiToken }}"}}).then((t=>{const s=t.data.data;this.favoriteProducts.push(...s),this.isLoading=!1})).catch((t=>{this.isLoading=!1,console.log("ERROR SERVERSIDE: ".err.response)}))}}}
</script>
@endpush
