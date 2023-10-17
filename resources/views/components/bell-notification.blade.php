<div x-data="handleNotification()">
    <button class="notif__bell relative" :disabled="isBellNotifOpen"
        @click="isBellNotifOpen = true; getNotifications()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-8 h-8 p-1 rounded-full hover:bg-slate-500 transition-colors duration-200 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        <div class="absolute right-1.5 top-1.5 w-2 h-2 rounded-full bg-rose-500"></div>
    </button>
    <div class="triangle__notif__bell" x-show="isBellNotifOpen" x-cloak x-transition:enter.delay.130ms
        x-transition:leave.delay.50ms></div>
    <div class="notif__dropdown absolute md:top-24 top-20 right-1 bg-white md:w-[480px] w-11/12 p-1 rounded-lg z-[9999] no-scrollbar"
        :class="isLoading ? 'h-[140px]' : 'h-[300px] min-h-max overflow-y-scroll'" x-show="isBellNotifOpen" x-cloak
        x-transition:enter.duration.400ms x-transition:leave.delay.50ms>
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
        <template x-if="notifications.length > 0">
            <div class="body__notif" x-show="!isLoading" x-cloak>
                <template x-for="notif in notifications" :key="notif.id">
                    <div @click.prevent="alertNotif = true; handleNotifRead(notif.id); isNotifPopupOrRedirect(notif.type_notif, notif.id, notif.notif_slug)"
                        class="notification flex justify-between items-center space-x-2 mt-3 p-4 mb-2 no-underline group hover:bg-primary-cyan-light rounded transition-colors duration-200 cursor-pointer">
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
                            <div :data-notif-id="notif.id" class="w-4 h-4 rounded-full  bg-red-500 animate-pulse">
                            </div>
                        </div>
                        <template x-if="notif.type_notif === 'popup'">
                          <div  x-show="openNotifModalPopup && notif.id === modalId"
                                x-transition:enter="motion-safe:ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-90"
                                x-transition:enter-end="opacity-100 scale-100"
                                class="w-full fixed inset-0 -left-2 z-50 flex items-center justify-center bg-primary-slate-light/60">
                              {{-- MODAL --}}
                              <div class="w-full max-w-xl h-auto px-6 py-4 mx-auto text-left bg-white rounded shadow"
                                  @click.away="openNotifModalPopup = false">
                                  <div class="flex items-center justify-end">
                                      <button type="button" class="z-50 cursor-pointer text-rose-500"
                                          @click.stop="openNotifModalPopup = false;">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                              viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12" />
                                          </svg>
                                      </button>
                                  </div>
                                  <div>
                                    <p x-text="notif.notif_title" class="uppercase font-extrabold text-lg text-primary-slate"></p>
                                    <p x-text="notif.notif_description" class="text-primary-slate-light text-xs mt-5"></p>
                                  </div>
                              </div>
                          </div>
                        </template>
                    </div>
                </template>
            </div>
            <hr class="text-slate-100 mx-3">
        </template>
        <div class="load__more text-center">
            <button x-show="!isLoading && hasMorePages" x-cloak @click="getNotifications()"
                class="text-black text-sm text-center mt-2 mb-2 cursor-pointer">Load More</button>
        </div>
        <template x-if="notifications.length == 0">
            <div x-show="!isLoading" x-cloak class="mt-2 mb-5">
                <img src="{{ asset('/img/StaticImage/Notif_Not_Found.webp') }}" class="w-full h-auto" alt="Not Found Notification">
                <p class="text-center text-xl uppercase text-rose-400 mt-4">tidak ada notifikasi</p>
            </div>
        </template>
    </div>
</div>
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
                            console.log(response.next_page_url)
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
                    console.log("redirect")
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

</script>
