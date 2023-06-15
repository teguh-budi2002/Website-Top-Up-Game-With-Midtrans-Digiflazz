 <div class="relative" x-data="{
                        activeSlides: 1,
                        imgUrls: ['https://source.unsplash.com/collection/190727/200x200', 'https://source.unsplash.com/user/traceofwind/likes/200x200', 'https://source.unsplash.com/user/erondu/200x200'],
                        autoSlide() {
                             setInterval(() => { 
                             this.activeSlides = this.activeSlides === this.imgUrls.length ? 1 : this.activeSlides + 1
                            }, 4000); 
                        },
                    }" x-init="autoSlide">
     <div style="width: 800px; height: 390px; border-radius: 6px" class="flex overflow-x-hidden relative">
         <template x-for="(img, index) in imgUrls" :key="index">
             <div class="absolute" x-show="activeSlides == index + 1" x-transition:enter="transition duration-1000"
                 x-transition:enter-start="transform translate-x-full" x-transition:enter-end="transform translate-x-0"
                 x-transition:leave="transition duration-1000" x-transition:leave-start="transform"
                 x-transition:leave-end="transform -translate-x-full">
                 <img class="w-[800px] h-96 object-cover rounded-md" alt="1" :src="img" />
             </div>
         </template>
     </div>
     <div class="flex justify-center items-center space-x-4 mt-4">
        <template x-for="(img, index) in imgUrls" :key="index">
            <button :class="activeSlides === index + 1 ? 'bg-white' : 'bg-slate-400'" class="w-3.5 h-3.5 rounded-full hover:bg-white cursor-pointer" @click="activeSlides = index + 1"></button>
        </template>
     </div>
 </div>
