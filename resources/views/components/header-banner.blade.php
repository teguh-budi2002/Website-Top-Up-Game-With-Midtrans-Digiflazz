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
    const swiper = new Swiper('.swiper', {
        direction: 'horizontal',
        // loop: true,
        effect: 'coverflow',
        speed: 700,
        centeredSlides: true,
        slidesPerView: 'auto',
        initialSlide: 1,
        centeredSlides: true,
        grabCursor: true,
        lazyLoadingInPrevNext: true,
        coverflowEffect: {
            rotate: 0,
            // stretch: 400,
            depth: 200,
            slideShadows: true,
        },
    });
    // swiper.slideNext();

    function handleBanner() {
        return {
            activeSlides: 1,
            imgUrls: [],
            init() {
                this.getBanner();
            },

            getBanner() {
                axios.get('/api/layout/banner', {
                        headers: {
                            'X-Custom-Token': '{{ $accessApiToken }}'
                        }
                    })
                    .then(res => {
                        const banner = res.data.banner.img_url
                        this.imgUrls.push(...banner)
                    }).catch(err => {
                        this.imgUrls = []
                    })

            }
        }
    }

</script>
@endpush
