<div class="items__box mt-3" x-data="{
    products: [],
    showImg: false,
    isLoading: false,
    async getProducts() {
        this.isLoading = true
        const res = await fetch('http://localhost:8000/api/get-products')
        this.products = await res.json()
        this.isLoading = false
    }
}"  x-init="getProducts()">
    <div class="flex justify-center" x-show="isLoading">
        <div class="custom_loader"></div>
    </div>
    <div class="flex justify-center">
        <div class="grid sm:grid-cols-5 grid-cols-2 gap-3" x-intersect.threshold.50="showImg = true"
        >
            <template x-for="product in products.data" :key="product.id">
                <div class="item_box group w-full bg-primary-slate rounded-md text-center" x-show="showImg" 
            x-transition:enter="transition ease-out duration-1500"
            x-transition:enter-start="opacity-0 scale-75"
            x-transition:enter-end="opacity-100 scale-100">
                    <a :href="'order/' + product.slug" class="no-underline">
                        <img :src="product.img_url" class="w-full rounded-t-md" alt="">
                        <span class="block pb-5 pt-3 capitalize text-primary-cyan group-hover:text-primary-cyan-light transition-colors duration-200" x-text="product.product_name"></span>
                    </a>
                </div>
            </template>
        </div>
    </div>
</div>
