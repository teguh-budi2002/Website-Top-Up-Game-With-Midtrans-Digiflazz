<style>
    .triangle__notif__bell {
        position: absolute;
        z-index: 40;
        right: 72px;
        top: 77px;
        border-left: 12px solid transparent;
        border-right: 12px solid transparent;
        border-bottom: 20px solid white;
    }

    .loader_notif {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        position: absolute;
        top: 65px;
        animation: rotate 1s linear infinite
    }

    .loader_notif::before {
        content: "";
        box-sizing: border-box;
        position: absolute;
        inset: 0px;
        border-radius: 50%;
        border: 5px solid #353349;
        animation: prixClipFix 2s linear infinite;
    }

    @keyframes rotate {
        100% {
            transform: rotate(360deg)
        }
    }

    @keyframes prixClipFix {
        0% {
            clip-path: polygon(50% 50%, 0 0, 0 0, 0 0, 0 0, 0 0)
        }

        25% {
            clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 0, 100% 0, 100% 0)
        }

        50% {
            clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 100% 100%, 100% 100%)
        }

        75% {
            clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 0 100%, 0 100%)
        }

        100% {
            clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 0 100%, 0 0)
        }
    }

</style>
<div x-data="handleNotification()">
    <div class="notif__bell relative z-[999]"
        @click="isHiddenBellNotifDot = true; localStorage.setItem('NOTIF_DOT', JSON.stringify(isHiddenBellNotifDot)); isBellNotifOpen = true; getNotifications()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-8 h-8 p-1 rounded-full hover:bg-slate-500 transition-colors duration-200 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        <div class="absolute right-1.5 top-1.5 w-2 h-2 rounded-full bg-rose-500" :class="isHiddenBellNotifDot ? 'hidden' : ''"></div>
    </div>
    <div class="triangle__notif__bell" x-show="isBellNotifOpen" x-transition:enter.delay.130ms x-transition:leave.delay.50ms></div>
    <div class="notif__dropdown absolute top-24 right-1 bg-white w-[480px] p-1 rounded-md z-50 no-scrollbar"
        :class="isLoading ? 'h-[140px]' : 'h-[300px] min-h-max overflow-y-scroll'" x-show="isBellNotifOpen" x-transition:enter.duration.400ms x-transition:leave.delay.50ms>
        <div class="header__notif flex justify-between items-center px-4 text-slate-600 mt-3">
            <p class="uppercase font-bold">Notifikasi</p>
            <div @click.stop="isBellNotifOpen = false">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor"
                    class="w-8 h-8 cursor-pointer hover:bg-red-500 hover:text-white p-1 rounded-full transition-colors duration-200">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </div>
        <div x-show="isLoading" class="text-center">
            <span class="loader_notif"></span>
        </div>
        <div class="body__notif">
            <template x-for="notif in notifications" :key="notif.id">
                <a x-cloak x-show="!isLoading" href="#"
                    @click="alertNotif = true; handleNotifRead(notif.id)"
                    class="notification flex justify-between items-center space-x-2 mt-3 p-4 mb-2 no-underline group hover:bg-primary-cyan-light rounded transition-colors duration-200">
                    <div>
                        <img :src="`/storage/page/notification/${notif.notif_img}`"
                            class="w-28 h-auto object-cover rounded-sm" alt="">
                    </div>
                    <div class="space-y-1.5 flex-1">
                        <p class="uppercase text-sm text-slate-800 group-hover:text-white font-extrabold"
                            x-text="notif.notif_title"></p>
                        <p class="notif_desc text-xs text-slate-400 group-hover:text-teal-100"
                            x-text="truncateString(notif.notif_description, 85)"></p>
                    </div>
                    <div class="alert__notif">
                        <div :data-notif-id="notif.id" class="w-4 h-4 rounded-full bg-red-500 animate-pulse">
                        </div>
                    </div>
                </a>
            </template>
        </div>
        <hr class="text-slate-100 mx-3">
        <div class="text-center">
            <button x-show="!isLoading && hasMorePages" @click="getNotifications()" class="text-black text-sm text-center mt-2 mb-2 cursor-pointer">Load More</button>
        </div>
    </div>
</div>
<script>
    function handleNotification() {
        return {
            isHiddenBellNotifDot: localStorage.getItem('NOTIF_DOT') === 'true',
            isBellNotifOpen: false,
            alertNotif: JSON.parse(localStorage.getItem('ALERT_NOTIF')) || [],
            hasUnreadNotif: false,
            notifications: [],
            isLoading: false,
            page: 1,
            hasMorePages: true,

            init() {
                
            },

            checkNotifAlreadyReadOrNot() {
                const alertNotif = JSON.parse(localStorage.getItem('ALERT_NOTIF')) || [];
                const notifications = this.notifications
                const notificationID = {};

                notifications.forEach(notif => {
                    notificationID[notif.id] = {id: notif.id}
                });

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
                const alertNotif =  JSON.parse(localStorage.getItem('ALERT_NOTIF')) || [];

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

            truncateString(str, limit = 10) {
                if (str.length <= limit) {
                    return str
                } else {
                    return str.substring(0, limit) + '...'
                }
            }

        }
    }

</script>
