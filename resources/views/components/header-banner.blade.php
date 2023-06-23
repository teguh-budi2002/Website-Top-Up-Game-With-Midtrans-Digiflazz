 <div class="relative w-full flex flex-col justify-center items-center" x-data="{
                        activeSlides: 1,
                        imgUrls: ['https://source.unsplash.com/collection/190727/200x200', 'https://source.unsplash.com/user/traceofwind/likes/200x200', 'https://source.unsplash.com/user/erondu/200x200'],
                        autoSlide() {
                             setInterval(() => { 
                             this.activeSlides = this.activeSlides === this.imgUrls.length ? 1 : this.activeSlides + 1
                            }, 4000); 
                        },
                    }" x-init="autoSlide">
     <div style="height: 390px; border-radius: 6px" class="md:w-[800px] w-full flex overflow-x-hidden relative ">
         <template x-for="(img, index) in imgUrls" :key="index">
             <div class="absolute inset-x-0" x-show="activeSlides == index + 1" x-transition:enter="transition duration-1000"
                 x-transition:enter-start="transform translate-x-full" x-transition:enter-end="transform translate-x-0"
                 x-transition:leave="transition duration-1000" x-transition:leave-start="transform"
                 x-transition:leave-end="transform -translate-x-full">
                 <img class="md:w-[800px] w-full h-96 object-cover rounded-md mx-auto" alt="1" :src="img" />
             </div>
         </template>
     </div>
     <div class="flex justify-center items-center space-x-4 mt-4">
        <template x-for="(img, index) in imgUrls" :key="index">
            <button :class="activeSlides === index + 1 ? 'bg-primary-cyan-light' : 'bg-teal-600'" class="w-9 h-1.5 rounded hover:bg-primary-cyan-light cursor-pointer" @click="activeSlides = index + 1"></button>
        </template>
     </div>
 </div>
