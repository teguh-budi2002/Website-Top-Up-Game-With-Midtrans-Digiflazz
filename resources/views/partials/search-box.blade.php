<div x-data="{ search: '', resultSearch: [], notFound: false }" x-effect="resultSearch = await doLiveSearch(search)" class="search_box relative flex w-fit">
  <div class="">
    <input type="text" name="search_product" x-model.debounce.500ms="search"
      class="bg-primary-light text-primary-light border-primary-light w-full rounded border border-solid"
      placeholder="Cari Games Yang Kamu Inginkan" autocomplete="off">
  </div>
  <template x-if="resultSearch.status !== '404'">
    <template x-for="result in resultSearch" :key="result.id">
      <li x-text="result.product_name"></li>
    </template>
  </template>
  <div x-show="resultSearch.status === '404'">
    <p>data tidak ada</p>
  </div>
  {{-- <div class="result_search absolute -bottom-12 h-auto w-full">
    <div
      class="result_tabs text-primary bg-primary flex cursor-pointer items-center justify-between rounded-b-md p-2 transition hover:bg-cyan-300">
      <p class="text-xl font-medium">Call Of Duty</p>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
        stroke="currentColor" class="h-6 w-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5" />
      </svg>
    </div>
  </div> --}}
</div>
<script>
  async function doLiveSearch(search) {
    if (!search) {
      return [];
    }

    let params = new URLSearchParams({
      search_product: search
    });

    const res = await fetch(`find-product-with-livesearch?${params.toString()}`)

    // return from variable datas between Array Obj if status 200 and Obj if status 404
    const datas = await res.json()

    if (datas.status == "200") {
      return datas.data
    } else if (datas.status == "404") {
      return datas
    }
  }
</script>
