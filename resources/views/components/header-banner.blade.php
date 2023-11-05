@push('css-custom')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endpush
<div class="w-full h-auto">
    <div class="flex justify-center">
        <div class="swiper md:w-10/12 w-full" x-data="handleBanner()">
            <div class="swiper-wrapper w-full">
                <template x-for="(img, index) in imgUrls" :key="index">
                    <div class="swiper-slide" style="width: auto !important;">
                        <img class="md:w-[1200px] w-full md:h-[350px] h-[200px] object-cover rounded-md" alt="banner_slider"
                            :src="`/storage/${img}`" />
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
@push('js-custom')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
const swiper=new Swiper(".swiper",{direction:"horizontal",effect:"coverflow",speed:700,centeredSlides:!0,slidesPerView:"auto",initialSlide:1,centeredSlides:!0,grabCursor:!0,coverflowEffect:{rotate:0,depth:200,slideShadows:!0}});function handleBanner(){return{activeSlides:1,imgUrls:[],init(){this.getBanner()},getBanner(){axios.get("/api/layout/banner",{headers:{"X-Custom-Token":"{{ $accessApiToken }}"}}).then((e=>{const i=e.data.banner.img_url;this.imgUrls.push(...i)})).catch((e=>{this.imgUrls=[]}))}}}swiper.slideNext();
</script>
@endpush
