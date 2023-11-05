<div class="w-full flex justify-center">
    <div class="md:w-3/4 w-11/12 flex md:overflow-x-auto overflow-x-scroll items-center justify-between custom-scrollbar">
          @foreach ($categories as $category)
          <div class="md:w-full w-2/5 md:pb-2 pb-1 cursor-pointer text-center m-0 md:flex-shrink flex-shrink-0"
              @click.prevent="isPanelActive = '{{ $category->id }}'; getProductsByCategory('{{ $category->id }}')"
              :class="{'md:border-b-2 border-b-0 border-solid dark:border-cyan-300 border-violet-500' : isPanelActive === '{{ $category->id }}' }">
              <div class="category_panel font-semibold md:text-base group text-xs dark:text-cyan-700 text-violet-300">
                  @if ($category->name_category === 'All Categories')
                  <i class="fas fa-regular fa-layer-group fa-lg mr-1 group-hover:text-violet-500 dark:group-hover:text-cyan-300 transition-colors duration-200 md:inline-block block md:text-left text-center md:mb-0 mb-5"
                      :class="{ 'dark:text-cyan-300 text-violet-500': isPanelActive === '{{ $category->id }}' }"></i>
                  @elseif ($category->name_category === 'Mobile Games')
                  <i class="fas fa-regular fa-gamepad fa-lg mr-1 group-hover:text-violet-500 dark:group-hover:text-cyan-300 transition-colors duration-200 md:inline-block block md:text-left text-center md:mb-0 mb-5"
                      :class="{ 'dark:text-cyan-300 text-violet-500': isPanelActive === '{{ $category->id }}' }"></i>
                  @elseif ($category->name_category === 'PC Games')
                  <i class="fas fa-reguler fa-desktop fa-lg mr-1 group-hover:text-violet-500 dark:group-hover:text-cyan-300 transition-colors duration-200 md:inline-block block md:text-left text-center md:mb-0 mb-5"
                      :class="{ 'dark:text-cyan-300 text-violet-500': isPanelActive === '{{ $category->id }}' }"></i>
                  @elseif ($category->name_category === 'Voucher')
                  <i class="fas fa-reguler fa-ticket fa-lg mr-1 group-hover:text-violet-500 dark:group-hover:text-cyan-300 transition-colors duration-200 md:inline-block block md:text-left text-center md:mb-0 mb-5"
                      :class="{ 'dark:text-cyan-300 text-violet-500': isPanelActive === '{{ $category->id }}' }"></i>
                  @elseif ($category->name_category === 'Pulsa')
                  <i class="fas fa-reguler fa-phone fa-lg mr-1 group-hover:text-violet-500 dark:group-hover:text-cyan-300 transition-colors duration-200 md:inline-block block md:text-left text-center md:mb-0 mb-5"
                      :class="{ 'dark:text-cyan-300 text-violet-500': isPanelActive === '{{ $category->id }}' }"></i>
                  @endif
                  <p class="dark:group-hover:text-cyan-300 group-hover:text-violet-500 transition-colors duration-200" :class="{ 'dark:text-cyan-300 text-violet-500': isPanelActive === '{{ $category->id }}' }">{{ $category->name_category }}</p>
              </div>
          </div>
          @endforeach
    </div>
</div>
<div class="loading__panel flex justify-center mt-24" x-show="isLoading">
    <div class="custom_loader"></div>
</div>
@foreach ($categories as $category)
<div class="body__panel mt-5 mb-5 flex justify-center" x-show="isPanelActive == '{{ $category->id }}' && !isLoading">
    <div class="md:w-3/4 w-11/12 h-auto">
        <div :class="{'grid lg:grid-cols-5 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-3' : productNotFound === false}">
            <template x-if="!productNotFound">
                <template x-for="product in productByCategory" :key="product.id">
                    <div class="item_box group w-full dark:bg-primary-slate-light/90 bg-white shadow-lg dark:border-2 dark:border-solid dark:border-primary-slate dark:hover:border-primary-cyan-light rounded-xl text-center transition-all duration-300" x-show="isPanelActive"
                        x-transition:enter="transition ease-out duration-1500"
                        x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100">
                        <a :href="'order/' + product.slug" class="no-underline">
                            <template x-if="!product.is_testing">
                                <img :src="`/storage/product/${product.product_name}/${product.img_url}`"
                                    class="w-full rounded-t-xl" :alt="`image product${product.product_name}`">
                            </template>
                            <template x-if="product.is_testing">
                                <img :src="product.img_url"
                                    class="w-full rounded-t-md" alt="logo product [DEV]">
                            </template>
                            <span
                                class="block pb-5 pt-3 capitalize dark:text-primary-cyan-light/80 text-violet-600 group-hover:text-violet-400 dark:group-hover:text-cyan-300 transition-colors duration-200"
                                x-text="product.product_name"></span>
                        </a>
                    </div>
                </template>
            </template>
        </div>
        <div class="loading__loadmore__panel flex justify-center md:mt-3 mt-5" x-show="isLoadingLoadMore">
            <div class="custom_loader"></div>
        </div>
        <div class="load__more text-center">
            <button x-show="!isLoading && loadMore && !isLoadingLoadMore"
                @click="loadMoreProduct('{{ $category->id }}')"
                class="text-primary-cyan-light text-sm text-center mt-5 mb-2 cursor-pointer">Load More</button>
        </div>
        <template x-if="productNotFound">
            <div class="w-full h-auto p-2 border border-solid mt-3 border-slate-400 bg-white/20">
                <p class="text-red-400 md:text-2xl text-md text-center uppercase">Produk Dengan Kategori
                    {{ $category->name_category }} Belum Tersedia.</p>
            </div>
        </template>

    </div>
</div>
@endforeach
@push('js-custom')
<script>
    function handleProductByCategory() {
        return {
            isPanelActive: '1',
            productByCategory: [],
            productNotFound: false,
            productLoadMoreNotFound: false,
            isLoading: false,
            isLoadingLoadMore: false,
            loadMore: false,
            page: 2,

            init() {
                this.getProductsByCategory('1')
            },

            getProductsByCategory(category_id) {
                this.isLoading = true
                // Re initialize or Reset value variable productNotFound && loadMore && page
                this.page = 2
                this.productNotFound = false
                this.loadMore = false
                axios.get(`/api/get-products-by-category?category_id=${category_id}`, {
                    headers: {
                        'X-Custom-Token': '{{ $token }}'
                    }
                }).then(res => {
                    if (res.data.code === 404) {
                        this.productNotFound = true
                    }
                    if (res.data.code === 200) {
                        this.productByCategory = res.data.data.data

                        if (res.data.data.next_page_url !== null) {
                            this.loadMore = true
                        }
                    }
                }).catch(err => {
                    console.log("ERROR GET PRODUCT BY CATEGORY: ", err)
                    this.isLoading = false
                }).finally(() => {
                    this.isLoading = false
                })
            },

            loadMoreProduct(category_id) {
                this.isLoadingLoadMore = true
                axios.get('/api/get-token').then(res => {
                    const token = res.data.data
                    axios.get(`/api/get-products-by-category?category_id=${category_id}&page=${this.page}`, {
                        headers: {
                            'X-Custom-Token': `${token}`
                        }
                    }).then(res => {
                        if (res.data.code === 404) {
                            this.productLoadMoreNotFound = true
                        }

                        if (res.data.code === 200) {
                            this.productByCategory.push(...res.data.data.data)
                            if (res.data.data.next_page_url) {
                                this.page++
                            } else {
                                this.loadMore = false
                            }
                        }
                    }).catch(err => {
                        console.log("ERROR GET LOADMORE PRODUCT BY CATEGORY: ", err)
                        this.isLoadingLoadMore = false
                    })
                    .finally(() => {
                        this.isLoadingLoadMore = false
                    })

                })
            }
        }
    }

</script>
@endpush
