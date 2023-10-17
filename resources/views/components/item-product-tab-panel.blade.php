<div class="w-full flex justify-center">
    <div class="md:w-3/4 w-11/12 flex items-center justify-between">
          @foreach ($categories as $category)
          <div class="w-full md:pb-2 pb-1 cursor-pointer text-center m-0"
              @click.prevent="isPanelActive = '{{ $category->id }}'; getProductsByCategory('{{ $category->id }}')"
              :class="{'md:border-b-2 border-b-0 border-solid border-cyan-300' : isPanelActive === '{{ $category->id }}' }">
              <div class="category_panel font-semibold text-cyan-700 hover:text-cyan-300 transition-colors duration-200 md:text-base text-xs"
                  :class="{ 'text-cyan-300': isPanelActive === '{{ $category->id }}' }">
                  @if ($category->name_category === 'Mobile Games')
                  <i class="fas fa-regular fa-gamepad fa-lg mr-1 md:inline-block block md:text-left text-center md:mb-0 mb-5"
                      :class="{ 'text-cyan-300': isPanelActive === '{{ $category->id }}' }"></i>
                  @elseif ($category->name_category === 'PC Games')
                  <i class="fas fa-reguler fa-desktop fa-lg mr-1 md:inline-block block md:text-left text-center md:mb-0 mb-5"
                      :class="{ 'text-cyan-300': isPanelActive === '{{ $category->id }}' }"></i>
                  @elseif ($category->name_category === 'Voucher')
                  <i class="fas fa-reguler fa-ticket fa-lg mr-1 md:inline-block block md:text-left text-center md:mb-0 mb-5"
                      :class="{ 'text-cyan-300': isPanelActive === '{{ $category->id }}' }"></i>
                  @elseif ($category->name_category === 'Pulsa')
                  <i class="fas fa-reguler fa-phone fa-lg mr-1 md:inline-block block md:text-left text-center md:mb-0 mb-5"
                      :class="{ 'text-cyan-300': isPanelActive === '{{ $category->id }}' }"></i>
                  @endif
                  <span
                      :class="{ 'text-cyan-300': isPanelActive === '{{ $category->id }}' }">{{ $category->name_category }}</span>
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
        <div :class="{'grid sm:grid-cols-5 grid-cols-2 gap-3' : productNotFound === false}">
            <template x-if="!productNotFound">
                <template x-for="product in productByCategory" :key="product.id">
                    <div class="item_box group w-full bg-primary-slate-light/90 border-2 border-solid border-primary-slate hover:border-primary-cyan-light rounded-xl text-center transition-all duration-300" x-show="isPanelActive"
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
                                class="block pb-5 pt-3 capitalize text-primary-cyan-light/80 group-hover:text-cyan-300 transition-colors duration-200"
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
