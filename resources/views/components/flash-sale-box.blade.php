@props(['flash_sales' => null])
<style>
    .flashsale_text{
      animation: glitch 2s linear infinite;
    }

    @keyframes glitch{
      2%,64%{
        transform: translate(2px,0) skew(0deg);
      }
      4%,60%{
        transform: translate(-2px,0) skew(0deg);
      }
      62%{
        transform: translate(0,0) skew(5deg); 
      }
    }

    .flashsale_text:before,
    .flashsale_text:after{
      content: attr(title);
      position: absolute;
      left: 0;
    }

    .flashsale_text:before{
      animation: glitchTop 1s linear infinite;
      clip-path: polygon(0 0, 100% 0, 100% 33%, 0 33%);
      -webkit-clip-path: polygon(0 0, 100% 0, 100% 33%, 0 33%);
    }

    @keyframes glitchTop{
      2%,64%{
        transform: translate(2px,-2px);
      }
      4%,60%{
        transform: translate(-2px,2px);
      }
      62%{
        transform: translate(13px,-1px) skew(-13deg); 
      }
    }

    .flashsale_text:after{
      animation: glitchBotom 1.5s linear infinite;
      clip-path: polygon(0 67%, 100% 67%, 100% 100%, 0 100%);
      -webkit-clip-path: polygon(0 67%, 100% 67%, 100% 100%, 0 100%);
    }

    @keyframes glitchBotom{
      2%,64%{
        transform: translate(-2px,0);
      }
      4%,60%{
        transform: translate(-2px,0);
      }
      62%{
        transform: translate(-22px,5px) skew(21deg); 
      }
    }

    .flickity-viewport {
        height: 240px !important;
    }

    .discount_flashsale {
      clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 51% 90%, 0% 100%); 
    }

    /* .description_flashsale {
      clip-path: polygon(16% 0, 85% 0, 100% 50%, 100% 100%, 0 100%, 0% 50%);
    } */
</style>
<div x-data="handleFlashsale()">
  <div class="header_countdown flex justify-between items-center bg-black p-2 px-6 rounded-t-md">
      <div class="left_item flex items-center space-x-2">
          <p class="text-2xl font-extrabold text-yellow-400 flashsale_text" title="FLASH SALE" style="text-shadow: 2px 0 10px #fbf2c8;">FLASH SALE</p>
      </div>
      <div class="right_item flex items-center space-x-2">
        <p class="w-8 text-center p-1 bg-white text-rose-400 font-semibold rounded" x-text="countdown.days"></p>
        <p class="font-extrabold text-white">:</p>
        <p class="w-8 text-center p-1 bg-white text-rose-400 font-semibold rounded" x-text="countdown.hours"></p>
        <p class="font-extrabold text-white">:</p>
        <p class="w-8 text-center p-1 bg-white text-rose-400 font-semibold rounded" x-text="countdown.minutes"></p>
        <p class="font-extrabold text-white">:</p>
        <p class="w-8 text-center p-1 bg-white text-rose-400 font-semibold rounded" x-text="countdown.seconds"></p>
      </div>
  </div>
  <div class="product_flashsale bg-white p-2 whitespace-nowrap space-x-2 overflow-x-autp overflow-y-hidden no-scrollbar">
      <div class="grid grid-cols-1">
          <div class="row-start-2 col-start-1" x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 transform scale-90"
              x-transition:enter-end="opacity-100 transform scale-100"
              x-transition:leave="transition ease-in duration-300"
              x-transition:leave-start="opacity-100 transform scale-100"
              x-transition:leave-end="opacity-0 transform scale-90">
              <div class="grid grid-cols-1 grid-rows-1 py-2">
                  <div class="carousel" x-ref="carousel">
                   @foreach ($flash_sales[0]->items_flashsale as $item)
                      <div class="flashsale_items w-auto flickity-viewport px-2">
                        <a href="{{ URL('/order/' . $item->product->slug) }}" class="no-underline">
                          <div class="relative w-full h-full">
                            <div class="discount_flashsale p-1.5 rounded-tr-md bg-yellow-300 absolute right-[7px] top-0">
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
                                    ($item->discount_fixed . " %")
                                  }}
                              </p>
                              <p class="font-semibold text-white text-xs">OFF</p>
                            </div>
                            <figure class="w-full h-full">
                              <img class="w-[188px] h-[240px] object-cover object-center mr-2 rounded-md" data-flickity-lazyload="{{ asset('/storage/product/' . $item->product->product_name . '/' . $item->product->img_url) }}"
                                    loading="lazy">
                            </figure>
                            <div class="description_flashsale absolute bg-blue-500/90 shadow-md shadow-blue-700 rounded-b-md w-[188px] p-2 left-0 right-0 bottom-0">
                              <p class="item_name text-xs font-semibold truncate text-white">{{ $item->item->nominal }} - {{ $item->item->item_name }}</p>
                              <p class="price_after_discount text-sm font-extrabold text-green-500 bg-green-200 py- px-2 mt-1 mb-1 rounded-md w-fit">Rp {{ Cash($item->price_after_discount) }}</p>
                              <p class="price_before_discount text-xs text-rose-300 line-through">Rp {{ Cash($item->item->price) }}</p>
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
      flashsaleDatas: [],
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
        const interval = setInterval(() => {
                          const now = Date.now();

                          if (now < this.end) {
                              this.calculateCountdown(this.end);
                            } else {
                              // this.showCountdown = false;
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
