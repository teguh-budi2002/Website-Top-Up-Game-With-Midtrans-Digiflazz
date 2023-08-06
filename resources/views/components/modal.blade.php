<div x-show="isOpen" @keydown.window.prevent.esc="isOpen = false" x-transition:enter="transition duration-300"
    x-transition:enter-start="opacity-0 transform -translate-y-4"
    x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition duration-300"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform -translate-y-4"
    class="fixed h-full w-full overflow-y-auto bg-gray-600 bg-opacity-50 md:inset-0 top-0 left-0">
    <div class="bg-primary-slate relative md:top-28 top-28 mx-auto md:w-4/12 w-10/12 cursor-pointer rounded-t-md p-5">
        <div class="md:mt-3 md-0 text-center">
            {{ $slot }}
        </div>
        {{-- Modal Footer --}}
        <div
            class="border-primary-cyan-light absolute left-0 mt-5 w-full rounded-b-md border-0 border-t border-solid bg-primary-slate p-2">
            <div class="text-primary-cyan flex items-center space-x-1 text-xs">
                <div class="esc_kbod flex h-6 w-8 items-center justify-center rounded bg-white p-1.5 leading-relaxed">
                    <span class="esc">esc</span>
                </div>
                <span class="transition-colors hover:text-cyan-300">to close</span>
            </div>
        </div>
    </div>
</div>
