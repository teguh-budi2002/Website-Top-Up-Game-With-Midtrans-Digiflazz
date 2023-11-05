<nav x-data="{ isOpen: false }" class="border-violet-500 dark:border-primary-cyan-light bg-white/90 dark:bg-primary-slate-light flex justify-between items-center w-full border-0 border-b-2 border-solid lg:py-6 md:py-3 py-[9px] lg:px-12 md:px-5 px-5 text-white">
    <div class="logo">
        <a href="{{ URL('/') }}">
            @if (app('seo_data')->logo_website)
            <img src="{{ asset('/storage/seo/logo/website/' . app('seo_data')->logo_website) }}"
                class="md:w-auto md:h-16 w-auto h-12 rounded" alt="logo_website">
            @else
            <img src="{{ asset('/img/logo_with_bg.png') }}" class="md:w-auto md:h-16 w-auto h-12 rounded" alt="logo_website">
            @endif
        </a>
    </div>

    <div class="w-full flex items-center lg:justify-between sm:justify-around md:px-5 px-0">
        <div class="text__nav lg:block hidden">
            <p class="text-3xl font-semibold italic dark:text-slate-300 text-slate-600">
                {{ $navigation->text_head_nav ?? "Website Top Up Game Termurah" }}</p>
        </div>
        <div class="md:w-auto w-full flex justify-end items-center space-x-2">
            {{-- Search Box Main Page --}}
            @include('partials.search-box')

            <div class="right_menu">
                <div class="flex items-center space-x-3 mt-2">
                    <x-bell-notification />
                    <x-dark-mode-switcher />
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="mobile_nav_bottom fixed bottom-0 w-full h-20 p-2 bg-violet-400 dark:bg-primary-slate md:hidden block z-[99999]">
    <div class="flex items-center justify-around space-x-2 space-y-2">
        <a href="{{ URL('/') }}" class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-8 h-8 text-white">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
        </a>
        <div x-data="handleDarkmode()" class="relative bg-slate-50 dark:bg-primary-slate-light rounded-md p-2 shadow-md">
            <input type="checkbox" :checked="isDark" value="" @click="toggleDarkmode(event)" class="absolute w-10 h-16 opacity-0 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor"
                class="w-8 h-8 text-yellow-400 mx-auto block dark:hidden">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor"
                class="w-8 h-8 dark:text-cyan-500 mx-auto hidden dark:block">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
            </svg>
        </div>
        <a href="{{ URL('lacak-pesanan') }}" class="text-center">
            <i class="fa-solid fa-file-invoice fa-xl text-white"></i>
        </a>
    </div>
</div>
@push('js-custom')
<script>
    function handleNotification() {
        return {
            isBellNotifOpen: false,
            alertNotif: JSON.parse(localStorage.getItem('ALERT_NOTIF')) || [],
            hasUnreadNotif: false,
            notifications: [],
            isLoading: false,
            page: 1,
            hasMorePages: true,
            openNotifModalPopup: false,
            modalId: 0,

            init() {

            },

            checkNotifAlreadyReadOrNot() {
                const alertNotif = JSON.parse(localStorage.getItem('ALERT_NOTIF')) || [];
                const notifications = this.notifications
                const notificationID = {};
                if (notifications.length) {
                    notifications.forEach(notif => {
                        notificationID[notif.id] = {
                            id: notif.id
                        }
                    });
                }

                alertNotif.forEach(alert => {
                    const notif = notificationID[alert.notif_id];
                    if (notif) {
                        setTimeout(() => {
                            let hiddenDot = document.querySelector(`[data-notif-id="${notif.id}"]`);
                            hiddenDot.classList.add('invisible')
                        }, 1);
                    }
                })
            },

            handleNotifRead(notifId) {
                const alertNotif = JSON.parse(localStorage.getItem('ALERT_NOTIF')) || [];

                // Check Existing Notif
                const notifExists = alertNotif.some(alert => alert.notif_id === notifId);
                if (!notifExists) {
                    alertNotif.push({
                        notif_id: notifId,
                        is_open: true
                    });

                    let hiddenDot = document.querySelector(`[data-notif-id="${notifId}"]`);
                    hiddenDot.classList.add('invisible')
                    localStorage.setItem("ALERT_NOTIF", JSON.stringify(alertNotif));
                }
            },

            getNotifications() {
                this.isLoading = true
                axios.get("/api/get-token").then(res => {
                    const token = res.data.data

                    axios.get(`/api/notifications/get-notifications?page=${this.page}`, {
                        headers: {
                            'X-Custom-Token': token
                        }
                    }).then(res => {
                        if (res.status == 200) {
                            const response = res.data.data
                            this.notifications.push(...response.data);
                            this.checkNotifAlreadyReadOrNot()
                            this.isLoading = false
                            if (response.next_page_url) {
                                this.page++
                            } else {
                                this.hasMorePages = false
                            }

                        }
                    }).catch(err => {
                        this.isLoading = false
                    })
                })
            },

            isNotifPopupOrRedirect(type_notif, notif_id, notif_slug) {
                if (type_notif === 'redirect') {
                    window.location.replace(`/notifikasi/${notif_slug}`)
                } else if (type_notif === 'popup') {
                    this.modalId = notif_id
                    this.openNotifModalPopup = true
                }
            },

            truncateString(str, limit = 10) {
                if (str.length <= limit) {
                    return str
                } else {
                    return str.substring(0, limit) + '...'
                }
            }

        }
    }

    function handleDarkmode() {
        let html = document.documentElement
        return {
            isDark: localStorage.getItem('darkmode') === 'true',

            toggleDarkmode(event) {
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
