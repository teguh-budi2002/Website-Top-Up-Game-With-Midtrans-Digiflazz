<div class="mobile__display__header md:hidden block md:mx-0 mx-3 mb-10">
    <div>
        <div class="top_section md:mt-0 mt-60 border-0 border-b border-solid border-slate-500 pb-4">
            <img src="{{ asset('/storage/product/' . $product->product_name . '/' . $product->img_url) }}"
                class="w-20 h-20 rounded-full border border-solid border-slate-400"
                alt="logo {{ $product->product_name }}">
            <p class="mt-5 font-bold text-xl text-white">Top Up
                Game [{{ $product->product_name }}]</p>
        </div>
        <div class="badge mt-5">
            <div class="flex items-center space-x-3">
                <div
                    class="badge_support flex items-center space-x-2 bg-slate-400 hover:bg-white rounded-lg p-1 px-2 w-fit text-[10px] transition-colors duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                    <span class="font-semibold">Layanan 24 Jam</span>
                </div>
                <div
                    class="badge_fast_transaction flex items-center space-x-2 bg-slate-400 hover:bg-white rounded-lg p-1 px-2 w-fit text-[10px] transition-colors duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                    </svg>
                    <span class="font-semibold">Proses Transaksi Cepat</span>
                </div>
                <div
                    class="badge_secure_transaction flex items-center space-x-2 bg-slate-400 hover:bg-white rounded-lg p-1 px-2 w-fit text-[10px] transition-colors duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    <span class="font-semibold">Pembayaran Aman</span>
                </div>
            </div>
        </div>
    </div>
</div>
