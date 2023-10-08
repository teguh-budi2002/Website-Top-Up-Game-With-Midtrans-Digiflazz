 <div class="relative w-full flex flex-col justify-center items-center" x-data="handleBanner()">
    <template x-if="imgUrls.length > 0">
        <div style="border-radius: 6px" class="md:w-[1100px] w-full md:h-[390px] h-[200px] flex overflow-x-hidden relative">
            <template x-for="(img, index) in imgUrls" :key="index">
               <div class="absolute inset-x-0" x-show="isActiveSlide(index + 1)"
                   x-transition:enter="transition duration-1000" x-transition:enter-start="transform translate-x-full"
                   x-transition:enter-end="transform translate-x-0" x-transition:leave="transition duration-1000"
                   x-transition:leave-start="transform" x-transition:leave-end="transform -translate-x-full">
                   <img x-cloak class="md:w-[1100px] w-full md:h-96 h-[200px] object-cover rounded-md mx-auto" alt="1" :src="`/storage/${img}`" />
               </div>
            </template>
        </div>
    </template>
    
    <template x-if="imgUrls.length == 0">
        <div class="md:w-[800px] w-full h-[390px] flex relative overflow-x-hidden">
            <div class="absolute inset-x-0">
                <div class="bg-white/20 border border-solid border-slate-400 h-96 rounded flex justify-center items-center">
                    <p class="text-2xl text-center">Banner Belum Dicantumkan Oleh Pihak Toko</p>
                </div>
            </div>
        </div>
    </template>
    <div class="flex justify-center items-center md:space-x-4 space-x-2 mt-4">
        <template x-for="(img, index) in imgUrls" :key="index">
         <button :class="isActiveSlide(index + 1) ? 'bg-primary-cyan-light' : 'bg-teal-600'"
               class="md:w-9 md:h-1.5 w-2 h-2 md:rounded rounded-full hover:bg-primary-cyan-light cursor-pointer"
               @click="activeSlides = index + 1"></button>
        </template>
    </div>
 </div>
 @push('js-custom')
 <script>
     function handleBanner() {
         return {
             activeSlides: 1,
             imgUrls: [],
             init() {
             this.getBanner();
                this.startAutoSlide();
             },
             isActiveSlide(slideIndex) {
                return this.activeSlides === slideIndex;
            },
            startAutoSlide() {
                setInterval(() => {
                    this.activeSlides = (this.activeSlides % this.imgUrls.length) + 1;
                }, 4000);
            },

             getBanner() {
                axios.get('/api/get-token').then(res => {
                    const token = res.data.data
                    axios.get('/api/layout/banner', {
                        headers: {
                            'X-Custom-Token': `${token}`
                        }
                    })
                    .then(res => {
                        const banner = res.data.banner.img_url
                        this.imgUrls.push(...banner)
                    }).catch(err => {
                        this.imgUrls = []
                    })
                })
             }
         }
     }

 </script>
 @endpush
