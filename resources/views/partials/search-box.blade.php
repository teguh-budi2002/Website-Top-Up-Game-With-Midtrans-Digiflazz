<div x-data="liveSearch()" class="search_box z-[999]">
    <div class="search__btn__desktop md:block hidden">
        <div class="bg-slate-200 dark:bg-primary-slate dark:border-primary-cyan-light border-violet-500 flex h-auto w-80 cursor-pointer flex-row items-center justify-between space-x-3 rounded-md border-2 border-solid p-2"
            @keydown.window.prevent.ctrl.k="isOpen = true" @click="isOpen = true">
            <div class="space-x-2">
                <i class="fa-solid fa-magnifying-glass text-primary-light"></i>
                <span class="text-gray-400">
                    Search
                </span>
            </div>
            <div class="k-bord_key text-primary-cyan flex items-center space-x-1 text-xs">
                <div class="ctrl_kbod flex h-8 w-8 items-center justify-center rounded bg-white shadow-md p-1 leading-relaxed">
                    <span class="ctrl text-center font-semibold">ctrl</span>
                </div>
                <div>
                    <span class="dark:text-white text-slate-600">+</span>
                </div>
                <div class="k_kbod flex h-8 w-8 items-center justify-center rounded bg-white shadow-md p-1 leading-relaxed">
                    <span class="k text-center font-semibold">K</span>
                </div>
            </div>
        </div>
    </div>
    <div class="search__btn__mobile md:hidden block">
        <div class="dark:bg-slate-800 bg-violet-500 hover:bg-violet-400 w-9 h-9 flex justify-center items-center rounded-md cursor-pointer" @click="isOpen = true">
            <i class="fa-solid fa-magnifying-glass dark:text-primary-cyan-light text-white"></i>
        </div>
    </div>
    <div class="modal__search">
        <x-modal>
            <div class="md:hidden block mb-5">
                <div class="flex justify-end" @click="isOpen = false">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8 bg-rose-400 p-1 text-rose-200 rounded-md">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <input type="text" name="search_product" @click="isOpen = true" x-model="search" x-on:input="debounceSearch"
                class="bg-slate-200 focus:outline-none focus:border-violet-500 dark:bg-primary-slate-light dark:text-primary-cyan-light text-primary-cyan dark:border-primary-cyan-light border-violet-500 w-full rounded-lg border-2 border-solid"
                autofocus placeholder="Cari Games Yang Kamu Inginkan" autocomplete="off">

            <div x-show="noRecentSearch" class="mt-3 text-center">
                <p class="text-slate-600 dark:text-white md:text-base text-sm">Apa Yang Ingin Kamu Cari?</p>
            </div>

            <div x-show="isLoading" class="mt-4 mb-2">
                <div class="text-center">
                    <div role="status">
                        <svg aria-hidden="true" class="inline w-8 h-8 mr-2 text-gray-200 animate-spin dark:fill-primary-cyan-light fill-violet-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>

            <div x-show="resultSearch" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0">
                <template x-for="result in resultSearch" :key="result.id">
                    <a :href="`/order/${result.slug}`"
                        @click="setRecentSearch({url: $event.currentTarget.getAttribute('href'), name: result.product_name})"
                        class="result_search bg-violet-500 hover:bg-violet-300 dark:bg-primary-slate  h-auto w-full flex cursor-pointer items-center justify-between rounded-md p-2 mt-3 transition dark:hover:bg-primary-slate-light text-xl font-medium no-underline dark:text-primary-cyan-light text-white">
                        <span x-text=" result.product_name" class="result_tabs md:text-base text-sm"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </template>
            </div>

            <div class="mt-5 mb-3 text-center" x-show="notFound" x-transition.duration.400ms>
                <svg width="40" height="40" class="mb-4 mx-auto text-slate-600 dark:text-white" viewBox="0 0 20 20" fill="none" fill-rule="evenodd"
                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M15.5 4.8c2 3 1.7 7-1 9.7h0l4.3 4.3-4.3-4.3a7.8 7.8 0 01-9.8 1m-2.2-2.2A7.8 7.8 0 0113.2 2.4M2 18L18 2">
                    </path>
                </svg>
                <p class="text-slate-600 dark:text-white md:text-base text-sm">Pencarian <span class="font-semibold text-red-500" x-text="search"></span> tidak ditemukan.</p>
            </div>
            <div class="flex items-center space-x-2 mt-3">
                <span class="text-sm dark:text-primary-cyan-light text-violet-500">Recent</span>
                <div class="w-full border-[1px] border-solid dark:border-primary-cyan-light border-violet-500"></div>
            </div>
            <div class="recent__search">
                <template x-for="(recent, index) in recentSearch" :key="recent.id">
                    <a :href="`{{ env('APP_URL') }}${recent.url}`" x-show="recent" :data-id="recent.id"
                        class="recent_search bg-violet-500 hover:bg-violet-300 dark:bg-primary-slate h-auto w-full flex cursor-pointer items-center justify-between rounded-md p-2 mt-3 dark:hover:bg-primary-slate-light text-xl font-medium no-underline text-white dark:text-primary-cyan-light z-50">
                        <span x-text="recent.name" class="result_tabs md:text-base text-sm"></span>
                        <svg @click.prevent="deleteRecentSearch(recent.id)" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="w-6 h-6 p-0.5 hover:rounded-full hover:bg-red-400 hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                </template>
            </div>
        </x-modal>
    </div>
</div>
@push('js-custom')
<script>
function liveSearch(){return{search:"",isLoading:!1,resultSearch:[],noRecentSearch:!0,notFound:!1,isOpen:!1,recentSearch:[],init(){let e=JSON.parse(localStorage.getItem("__SEARCH__"));e&&Array.isArray(e)||(e=[],localStorage.setItem("__SEARCH__",JSON.stringify(e))),this.loadRecentSearches()},debounceSearch(){clearTimeout(this.debounceTimeout),this.debounceTimeout=setTimeout((()=>{this.performSearch()}),500)},performSearch(){if(this.isLoading=!0,this.search.length>0){this.noRecentSearch=!1;let e=new URLSearchParams({search_product:this.search});axios.get(`/api/find-product-with-livesearch?${e.toString()}`).then((e=>{404!==e.data.code?(this.isLoading=!1,this.notFound=!1,this.resultSearch=e.data.data):(this.isLoading=!1,this.resultSearch=[],this.notFound=!0)})).catch((e=>{console.log("ERROR in Server Side")}))}else this.isLoading=!1,this.notFound=!1,this.noRecentSearch=!0,this.resultSearch=[]},setRecentSearch(e){let t=JSON.parse(localStorage.getItem("__SEARCH__"))||[],a=null;if(t.map((e=>{a=e.name})),a===e.name)return null;t.push({id:1e6*Math.random(),url:e.url,name:e.name,isRecent:!0,isDeleted:!1,timestamp:Date.now()}),localStorage.setItem("__SEARCH__",JSON.stringify(t)),this.noRecentSearch=!1,this.recentSearch=t},loadRecentSearches(){const e=localStorage.getItem("__SEARCH__");this.recentSearch=e?JSON.parse(e):[]},deleteRecentSearch(e){let t=JSON.parse(localStorage.getItem("__SEARCH__"))||[],a=document.querySelector(`[data-id="${e}"]`);a.style.transition="opacity 0.5s, transform 0.5s",a.style.opacity="0",a.style.transform="translateX(-80%)",setTimeout((()=>{let a=t.filter((t=>t.id!==e));localStorage.setItem("__SEARCH__",JSON.stringify(a)),this.recentSearch=a}),500)}}}
</script>
@endpush
