<div x-data="liveSearch()" x-init="init()" class="search_box z-50">
    <div class="search__btn bg-primary-slate-light border-primary-cyan-light flex h-auto w-80 cursor-pointer flex-row items-center justify-between space-x-3 rounded border border-solid p-2"
        @keydown.window.prevent.ctrl.k="isOpen = true" @click="isOpen = true">
        <div class="space-x-2">
            <i class="fa-solid fa-magnifying-glass text-primary-light"></i>
            <span class="text-gray-400">
                Search
            </span>
        </div>
        <div class="k-bord_key text-primary-cyan flex items-center space-x-1 text-xs">
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
            <input type="text" name="search_product" @click="isOpen = true"
                x-model="search" x-on:input="debounceSearch"
                class="bg-primary-slate-light text-primary-cyan-light border-primary-cyan-light w-full rounded border border-solid"
                autofocus placeholder="Cari Games Yang Kamu Inginkan" autocomplete="off">

            <div x-show="noRecentSearch" class="mt-3 text-center text-white/90">
                <p>Apa Yang Ingin Kamu Cari?</p>
            </div>

            <div x-show="resultSearch" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0">
                <template x-for="result in resultSearch" :key="result.id">
                    <a href="order/test"
                        @click.prevent="setResultSearch({url: $event.currentTarget.getAttribute('href'), name: result.product_name})"
                        class="result_search bg-primary-slate  h-auto w-full flex cursor-pointer items-center justify-between rounded-sm p-2 mt-3 transition hover:bg-cyan-300 text-xl font-medium no-underline text-primary-cyan"">
                <span x-text=" result.product_name" class="result_tabs">
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </template>
            </div>

            <div class="mt-5 mb-3" x-show="notFound" x-transition.duration.400ms>
                <svg width="40" height="40" class="mb-2" viewBox="0 0 20 20" fill="none" fill-rule="evenodd"
                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M15.5 4.8c2 3 1.7 7-1 9.7h0l4.3 4.3-4.3-4.3a7.8 7.8 0 01-9.8 1m-2.2-2.2A7.8 7.8 0 0113.2 2.4M2 18L18 2">
                    </path>
                </svg>
                <p>Pencarian <span class="font-semibold text-red-500" x-text="search"></span> tidak ditemukan.</p>
            </div>
            <div class="flex items-center space-x-2 mt-3">
                <span class="text-sm text-primary-cyan-light">Recent</span>
                <div class="w-full border-[1px] border-solid border-primary-cyan-light"></div>
            </div>
            <div class="recent__search">
                <template x-for="(recent, index) in recentSearch" :key="recent.id">
                    <a :href="recent.url" x-cloak x-show="recent"
                        :data-id="recent.id"
                        class="result_search bg-primary h-auto w-full flex cursor-pointer items-center justify-between rounded-sm p-2 mt-3 hover:bg-primary-cyan-light text-xl font-medium no-underline text-primary-cyan z-50">
                        <span x-text="recent.name" class="result_tabs "></span>
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

<script>
    function liveSearch() {
        return {
            search: '',
            resultSearch: [],
            noRecentSearch: true,
            notFound: false,
            isOpen: false,
            recentSearch: [],
            init() {
                // INIT LOCALSTORAGE KEY
                // Get the value from localStorage
                let recentSearchArr = JSON.parse(localStorage.getItem('__SEARCH__'));

                // Check if the value exists and if it is an array
                if (!recentSearchArr || !Array.isArray(recentSearchArr)) {
                    // If it doesn't exist or is not an array, set an empty array as the default value
                    recentSearchArr = [];

                    // Save the default array to localStorage
                    localStorage.setItem('__SEARCH__', JSON.stringify(recentSearchArr));
                }

                this.loadRecentSearches();
            },

            debounceSearch() {
                clearTimeout(this.debounceTimeout);
                this.debounceTimeout = setTimeout(() => {
                    this.performSearch();
                }, 500);
            },

            performSearch() {
                if (this.search.length > 0) {
                    this.noRecentSearch = false
                    let params = new URLSearchParams({
                        search_product: this.search
                    });
                    axios.get(`find-product-with-livesearch?${params.toString()}`)
                        .then(response => {
                            if (response.data.status !== "404") {
                                this.notFound = false
                                this.resultSearch = response.data.data;
                            } else {
                                // resultSearch will be empty array when product not found
                                this.resultSearch = [];
                                this.notFound = true
                            }
                        })
                } else {
                    this.notFound = false
                    this.noRecentSearch = true
                    this.resultSearch = [];
                }
            },

            setResultSearch(result) {
                let recentSearch = JSON.parse(localStorage.getItem('__SEARCH__')) || [];

                // Check If Old Recent Search Is Same With Result Will Return NULL
                let oldRecentName = null
                recentSearch.map(val => {
                    oldRecentName = val.name
                });
                if (oldRecentName === result.name) {
                    return null
                }

                recentSearch.push({
                    id: Math.random() * 1000000,
                    url: result.url,
                    name: result.name,
                    isRecent: true,
                    isDeleted: false,
                    timestamp: Date.now()
                });

                localStorage.setItem('__SEARCH__', JSON.stringify(recentSearch));
                // noRecentSearch will be FALSE when user click result search
                this.noRecentSearch = false
                // update rece
                this.recentSearch = recentSearch;
            },

            loadRecentSearches() {
                const storedSearches = localStorage.getItem('__SEARCH__');
                this.recentSearch = storedSearches ? JSON.parse(storedSearches) : [];
            },

            updateRecentSearches() {
                localStorage.setItem('__SEARCH__', JSON.stringify(this.recentSearch));
            },

            deleteRecentSearch(id) {
                let recentSearchStorage = JSON.parse(localStorage.getItem('__SEARCH__')) || []
                let recentSearchID = id

                // Apply animation to the item being deleted
                let deletedItem = document.querySelector(`[data-id="${id}"]`);
                    deletedItem.style.transition = 'opacity 0.5s, transform 0.5s';
                    deletedItem.style.opacity = '0';
                    deletedItem.style.transform = 'translateX(-80%)';

                setTimeout(() => {
                    let newVal = recentSearchStorage.filter((item) => item.id !== id)
                    localStorage.setItem('__SEARCH__', JSON.stringify(newVal));

                    // Update recentSearch Immediately
                    this.recentSearch = newVal;
                }, 500)

            }
        }
    }

</script>
