<div class="darkmode_switcher_desktop md:block hidden" x-data="handleDarkmode()">
    <div class="flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5 text-yellow-500 dark:text-slate-400">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
        </svg>
    
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" :checked="isDark" value="" @click="toggleDarkmode(event)" class="sr-only peer">
            <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[1.5px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-slate">
            </div>
        </label>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5 text-slate-400 dark:text-cyan-500">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
        </svg>
    </div>
</div>
<div class="md:hidden block fixed bottom-5 right-4 bg-slate-50 rounded-full w-14 h-14" x-data="handleDarkmode()">
    <div class="flex items-center justify-center relative">
        <input type="checkbox" :checked="isDark" value="" @click="toggleDarkmode(event)" class="absolute opacity-0">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-10 h-10 text-yellow-500 dark:text-slate-400 mx-auto mt-2 block dark:hidden">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-10 h-10 text-slate-400 dark:text-cyan-500 mx-auto mt-2 hidden dark:block">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
        </svg>
    </div>
</div>
@push('js-custom')
<script>
    function handleDarkmode() {
        let html = document.documentElement
        return {
            isDark: localStorage.getItem('darkmode') === 'true',

            toggleDarkmode(event) {
                console.log('woi')
                isChecked = event.target.checked
                if (isChecked) {
                    localStorage.setItem('darkmode', true)
                    html.classList.remove('turn-off-dark')
                    html.classList.add("dark")
                } else {
                    localStorage.setItem('darkmode', false)
                    html.classList.remove('dark')
                    html.classList.add("turn-off-dark")
                }
            }
        }
    }
</script>
@endpush
