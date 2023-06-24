<style>
    .notif__dropdown::before {
        content: "";
        position: absolute;
        right: 18px;
        top: -18px;
        width: 0;
        height: 0;
        border-left: 12px solid transparent;
        border-right: 12px solid transparent;
        border-bottom: 20px solid white;
    }
</style>
<div x-data="{ 
    isHiddenNotifDot: localStorage.getItem('NOTIF_DOT') === 'true', 
    isNotifOpen: false,
    alertNotif: localStorage.getItem('ALERT_NOTIF') === 'true',
    textDesc: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius explicabo veniam laboriosam beatae nobis nemo dignissimos mollitia dicta quaerat, cupiditate nostrum nisi error illo, in sequi! Iste porro ab rem?'
}" x-init="localStorage.setItem('ALERT_NOTIF', alertNotif.toString()); localStorage.setItem('isHiddenNotifDot', alertNotif.toString())">
    <div class="notif__bell relative" @click="isHiddenNotifDot = true; localStorage.setItem('NOTIF_DOT', isHiddenNotifDot.toString()); isNotifOpen = true">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-8 h-8 p-1 rounded-full hover:bg-slate-500 transition-colors duration-200 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        <div class="notif__dropdown absolute top-14 -left-96 bg-white w-[430px] h-auto p-1 rounded-md z-50" x-show="isNotifOpen" x-transition.duration.400ms>
            <div class="header__notif flex justify-between items-center px-4 text-slate-600 mt-3">
                <p class="uppercase font-bold">Notifikasi</p>
                <div @click.stop="isNotifOpen = false">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-8 h-8 cursor-pointer hover:bg-red-500 hover:text-white p-1 rounded-full transition-colors duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
            <a  href="#"
                @click="alertNotif = true; localStorage.setItem('ALERT_NOTIF', alertNotif.toString())"
                class="notification flex justify-start items-center space-x-2 mt-3 p-4 mb-2 no-underline group hover:bg-primary-cyan-light rounded transition-colors duration-200">
                <div>
                    <img src="https://source.unsplash.com/collection/190727/200x200" class="w-16 h-16 rounded-md"
                        alt="">
                </div>
                <div class="space-y-1.5">
                    <p class="uppercase text-slate-800 group-hover:text-teal-700 font-semibold">DISKON ANJAI</p>
                    <p class="notif_desc text-xs text-slate-400 group-hover:text-teal-100"
                        x-text="truncateString(textDesc, 85)"></p>
                </div>
                <div class="alert_notif">
                    <div class="w-4 h-4 rounded-full bg-red-500 animate-pulse" :class="{'invisible' : alertNotif}"></div>
                </div>
            </a>
            <hr class="text-slate-100 mx-3">
            <a  href="#"
                @click="alertNotif = true; localStorage.setItem('ALERT_NOTIF', alertNotif.toString())"
                class="notification flex justify-start items-center space-x-2 mt-3 p-4 mb-2 no-underline group hover:bg-primary-cyan-light rounded transition-colors duration-200">
                <div>
                    <img src="https://source.unsplash.com/collection/190727/200x200" class="w-16 h-16 rounded-md"
                        alt="">
                </div>
                <div class="space-y-1.5">
                    <p class="uppercase text-slate-800 group-hover:text-teal-700 font-semibold">DISKON ANJAI</p>
                    <p class="notif_desc text-xs text-slate-400 group-hover:text-teal-100"
                        x-text="truncateString(textDesc, 85)"></p>
                </div>
                <div class="alert_notif">
                    <div class="w-4 h-4 rounded-full bg-red-500 animate-pulse" :class="{'invisible' : alertNotif}"></div>
                </div>
            </a>
            <hr class="text-slate-100 mx-3">
        </div>
        <div class="absolute right-1.5 top-1.5 w-2 h-2 rounded-full bg-rose-500"
            :class="isHiddenNotifDot ? 'hidden' : ''"></div>
    </div>
</div>
<script>
    function truncateString(str, limit = 10) {
        if (str.length <= limit) {
            return str
        } else {
            return str.substring(0, limit) + '...'
        }
    }

</script>
