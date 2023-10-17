@props(['flash_sales' => null])
<div x-data="handleFlashsale()">
  <div class="header_countdown flex sm:flex-row flex-col justify-between items-center bg-black p-2 sm:px-6 px-0 rounded-t-md">
      <div class="left_item flex items-center space-x-2 sm:mb-0 mb-3">
          <p class="sm:text-2xl text-xl sm:text-start text-center font-extrabold text-yellow-400 flashsale_text" title="FLASH SALE" style="text-shadow: 2px 0 10px #fbf2c8;">FLASH SALE</p>
      </div>
      <div class="right_item flex items-center sm:space-x-2 space-x-0.5 sm:mb-0 mb-3">
          <div class="minutes w-fit text-center p-1 px-2 bg-primary-slate-light flex items-center sm:space-x-2 space-x-1 rounded">
              <p class="text-rose-400 font-semibold" x-text="countdown.days"></p>
              <p class="text-slate-500 font-semibold">Hari</p>
          </div>
          <p class="font-extrabold text-primary-slate-light">:</p>
          <div
              class="minutes w-fit text-center p-1 px-2 bg-primary-slate-light flex items-center sm:space-x-2 space-x-1 rounded">
              <p class="text-rose-400 font-semibold" x-text="countdown.hours"></p>
              <p class="text-slate-500 font-semibold">Jam</p>
          </div>
          <p class="font-extrabold text-primary-slate-light">:</p>
          <div
              class="minutes w-fit text-center p-1 px-2 bg-primary-slate-light flex items-center sm:space-x-2 space-x-1 rounded">
              <p class="text-rose-400 font-semibold" x-text="countdown.minutes"></p>
              <p class="text-slate-500 font-semibold">Menit</p>
          </div>
          <p class="font-extrabold text-primary-slate-light">:</p>
          <div
              class="minutes w-fit text-center p-1 px-2 bg-primary-slate-light flex items-center sm:space-x-2 space-x-1 rounded">
              <p class="text-rose-400 font-semibold" x-text="countdown.seconds"></p>
              <p class="text-slate-500 font-semibold">Detik</p>
          </div>
      </div>
  </div>
  <div class="product_flashsale bg-primary-slate-light/70 p-2 whitespace-nowrap space-x-2 overflow-x-autp overflow-y-hidden no-scrollbar">
      <div class="grid grid-cols-1">
          <div class="row-start-2 col-start-1" x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 transform scale-90"
              x-transition:enter-end="opacity-100 transform scale-100"
              x-transition:leave="transition ease-in duration-300"
              x-transition:leave-start="opacity-100 transform scale-100"
              x-transition:leave-end="opacity-0 transform scale-90">
              <div class="grid grid-cols-1 grid-rows-1 py-2">
                  <div class="carousel" x-ref="carousel">
                   @foreach ($flash_sales as $item)
                      <div class="flashsale_items w-auto rounded-md flickity-viewport px-2">
                        <a href="{{ URL('/order/' . $item->slug) }}" class="no-underline">
                          <div class="relative w-full h-full">
                            <div class="discount_flashsale p-1.5 rounded-tr-md bg-yellow-300 absolute sm:right-[7px] right-[8px] top-0">
                              <p class="font-semibold text-rose-500 text-center text-sm">  
                                  {{ $item->type_discount === 'discount_flat' ? 
                                    (
                                      $item->discount_flat >= 1000000 ? 
                                        (strval(floor($item->discount_flat / 1000000)) . "JT") :
                                        (
                                          $item->discount_flat >= 1000 ?
                                            (strval(floor($item->discount_flat / 1000)) . "K") :
                                            strval($item->discount_flat)
                                        )
                                    ) :
                                    ($item->discount_fixed . "%")
                                  }}
                              </p>
                              <p class="font-semibold text-white text-xs">OFF</p>
                            </div>
                            <figure class="w-full h-full">
                              @if (!$item->is_testing)
                                <img class="sm:w-[188px] sm:h-[158px] w-[170px] h-[164px] object-cover object-center mr-2 rounded-t-md" data-flickity-lazyload="{{ asset('/storage/product/' . $item->product_name . '/' . $item->img_url) }}"
                                      loading="lazy">      
                              @else        
                                <img class="sm:w-[188px] sm:h-[158px] w-[170px] h-[164px] object-cover object-center mr-2 rounded-t-md" data-flickity-lazyload="{{ asset($item->img_url) }}"
                                      loading="lazy">
                              @endif
                            </figure>
                            <div class="description_flashsale absolute left-0 right-0 bottom-0 bg-primary-slate rounded-b-md sm:w-[188px] w-[170px] h-auto p-2">
                              <p class="item_name text-xs font-semibold truncate text-white">{{ $item->nominal }} - {{ $item->item_name }}</p>
                              <p class="price_after_discount text-sm font-bold text-primary-cyan-light border-2 border-solid border-primary-cyan-light py- px-2 mt-1 mb-1 rounded w-fit">Rp {{ Cash($item->price_after_discount) }}</p>
                              <p class="price_before_discount text-xs text-rose-500 line-through">Rp {{ Cash($item->price) }}</p>
                            </div>
                          </div>
                        </a>
                      </div>
                   @endforeach
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
<script>
  function handleFlashsale() {
    const startTime = "{{ date('Y-m-d\\TH:i:s', strtotime($flash_sales[0]->start_time)) }}"
    const endTime = "{{ date('Y-m-d\\TH:i:s', strtotime($flash_sales[0]->end_time)) }}"
    const endTimeFlashsale = new Date(endTime).getTime();

    return {
      active: 0,
      isFlashsaleActive: '{{ $flash_sales[0]->is_flash_sale }}',
      end: endTimeFlashsale,
      countdown: {
          days: 0,
          hours: 0,
          minutes: 0,
          seconds: 0
      },

      init() {
        let flkty = new Flickity(this.$refs.carousel, {
          freeScroll: true,
          cellAlign: 'left',
          contain: true,
          prevNextButtons: false,
          pageDots: false,
          friction: 0.5,
          lazyLoad: 4,
          autoPlay: true
        });
        flkty.on('change', i => this.active = i);

        this.whenTheFlashsaleIsOn()
      },

      changeActive(i) {
        this.active = i;
        
        this.$nextTick(() => {
          let flkty = Flickity.data( this.$el.querySelectorAll('.carousel')[i] );
          flkty.resize();
        });
      },

      whenTheFlashsaleIsOn() {
        const isFlashsaleActive = this.isFlashsaleActive
        const endFlashsale = this.end
        const interval = setInterval(() => {
                          const now = Date.now();
                          if (now <= endFlashsale && isFlashsaleActive) {
                              this.calculateCountdown(endFlashsale);
                            } else {
                              clearInterval(interval);
                            }
                        }, 1000);
      },

      calculateCountdown(targetTime) {
          const timeDiff = targetTime - Date.now();
          this.countdown.days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
          this.countdown.hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
          this.countdown.minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
          this.countdown.seconds = Math.floor((timeDiff % (1000 * 60)) / 1000).toString().padStart(2, '0');
      }
    }
  }
</script>
