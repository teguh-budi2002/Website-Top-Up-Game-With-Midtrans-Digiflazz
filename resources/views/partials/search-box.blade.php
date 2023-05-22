<div x-data="{ search: '',
    resultSearch: [],
    notFound: false,
    isOpen: false,
    recentSearch: [] }" x-effect="resultSearch = await doLiveSearch(search), recentSearch = checkIfAnyRecentSearch()"
    class="search_box">
    <div class="search__btn bg-primary-light border-primary-light flex h-auto w-80 cursor-pointer flex-row items-center justify-between space-x-3 rounded border border-solid p-2"
        @keydown.window.prevent.ctrl.k="isOpen = true" @click="isOpen = true">
        <div class="space-x-2">
            <i class="fa-solid fa-magnifying-glass text-primary-light"></i>
            <span class="text-gray-400">
                Search
            </span>
        </div>
        <div class="k-bord_key text-primary flex items-center space-x-1 text-xs">
            <div class="ctrl_kbod flex h-8 w-8 items-center justify-center rounded bg-white p-1 leading-relaxed">
                <span class="ctrl text-center">ctrl</span>
            </div>
            <div>
                <span class="text-white">+</span>
            </div>
            <div class="k_kbod flex h-8 w-8 items-center justify-center rounded bg-white p-1 leading-relaxed">
                <span class="k text-center">K</span>
            </div>
        </div>
    </div>
    <div x-show="isOpen" @keydown.window.prevent.esc="isOpen = false" class="modal__search">
        <x-modal>
            <input type="text" name="search_product" @click="isOpen = true" x-model.debounce.500ms="search"
                class="bg-primary-light text-primary-light border-primary-light w-full rounded border border-solid"
                autofocus placeholder="Cari Games Yang Kamu Inginkan" autocomplete="off">

            <div x-show="resultSearch.length === 0 && recentSearch.length === 0" class="mt-3 text-center text-white/90">
                <p>No recent searches</p>
            </div>

            {{-- Validation Data From Rest API With Status Code --}}
            <template x-if="resultSearch.status !== '404'">
                <template x-for="result in resultSearch" :key="result.id">
                    <a href="order/test"
                        @click.prevent="setResultSearch({url: $event.currentTarget.getAttribute('href'), name: result.product_name})"
                        class="result_search bg-primary  h-auto w-full flex cursor-pointer items-center justify-between rounded-sm p-2 mt-3 transition hover:bg-cyan-300 text-xl font-medium no-underline text-primary"">
            <span x-text=" result.product_name" class="result_tabs">
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </template>
            </template>

            <div class="mt-5 mb-3" x-show="resultSearch.status === '404'" x-transition.duration.400ms>
                <svg width="40" height="40" class="mb-2" viewBox="0 0 20 20" fill="none" fill-rule="evenodd"
                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M15.5 4.8c2 3 1.7 7-1 9.7h0l4.3 4.3-4.3-4.3a7.8 7.8 0 01-9.8 1m-2.2-2.2A7.8 7.8 0 0113.2 2.4M2 18L18 2">
                    </path>
                </svg>
                <p>Pencarian <span class="font-semibold text-red-500" x-text="search"></span> tidak ditemukan.</p>
            </div>
            <div class="flex items-center space-x-2 mt-3">
                <span class="text-sm text-primary-light">Recent</span>
                <div class="w-full border-[1px] border-solid border-primary-light"></div>
            </div>
            <div x-show="recentSearch.length" x-transition:leave="transition ease-out duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="">
                <template x-for="recent in recentSearch" :key="recent.id">
                    <div {{-- :href="recent.url" --}}
                        class="result_search bg-primary  h-auto w-full flex cursor-pointer items-center justify-between rounded-sm p-2 mt-3 transition hover:bg-cyan-300 text-xl font-medium no-underline text-primary">
                        <span x-text="recent.name" class="result_tabs"></span>
                        <svg @click="deleteRecentSearch(recent.id)" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="w-6 h-6 p-0.5 hover:rounded-full hover:bg-red-400 hover:text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </template>
            </div>
        </x-modal>
    </div>
</div>

<script>
    async function doLiveSearch(search) {
        // Return From This Method Between Array Obj / Obj Depends On HTTP Status Code
        if (!search) {
            return [];
        }

        let params = new URLSearchParams({
            search_product: search
        });

        const res = await fetch(`find-product-with-livesearch?${params.toString()}`)

        const datas = await res.json()
        if (datas.status == "200") {
            return datas.data
        } else if (datas.status == "404") {
            return datas
        }
    }

    function checkIfAnyRecentSearch() {
        const dataSearching = JSON.parse(localStorage.getItem("__SEARCH__"))

        if (dataSearching !== null) {
            return dataSearching
        }
    }

    function setResultSearch(datas) {
        let recentSearches = JSON.parse(localStorage.getItem('__SEARCH__')) || [];

        // Check If Old Recent Search Is Any Will Return NULL
        let oldRecentName = null
        recentSearches.map(val => {
            oldRecentName = val.name
        });
        if (oldRecentName === datas.name) {
            return null
        }

        recentSearches.push({
            id: Math.random() * 1000000,
            url: datas.url,
            name: datas.name,
            isRecent: true,
            timestamp: Date.now()
        });

        localStorage.setItem('__SEARCH__', JSON.stringify(recentSearches));

        this.recentSearches = recentSearches;
    }

    function deleteRecentSearch(id) {
        const recentSearches = JSON.parse(localStorage.getItem('__SEARCH__')) || [];
        const recentSearchID = id

        // Delete Item On Array Obj By ID
        const newVal = recentSearches.filter((el) => el.id !== recentSearchID)

        // Saving Data Changing Into LocalStorage Again
        localStorage.setItem('__SEARCH__', JSON.stringify(newVal));
    }

</script>
