<aside class="sidebar flex-shrink-0 hidden bg-white border-r dark:border-primary-darker dark:bg-darker md:block overflow-x-hidden">
    <div class="flex flex-col h-full">
        <!-- Sidebar links -->
        <nav aria-label="Main" class="flex-1 px-2 py-4 space-y-2 ">
            <!-- Dashboards links -->
            <div x-data="{ isActive: false, open: false}">
                <a href="{{ URL('dashboard') }}"
                    class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                    :class="{'bg-primary-100 dark:bg-primary': isActive || open}" role="button" aria-haspopup="true"
                    :aria-expanded="(open || isActive) ? 'true' : 'false'">
                    <span aria-hidden="true">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </span>
                    <span class="ml-3 text-sm"> Dashboard </span>
                </a>
            </div>

            <!-- Website Setting Links -->
            <div x-data="{ isActive: false, open: false }">
                <a href="#" @click="$event.preventDefault(); open = !open"
                    class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                    :class="{ 'bg-primary-100 dark:bg-primary': isActive || open }" role="button" aria-haspopup="true"
                    :aria-expanded="(open || isActive) ? 'true' : 'false'">
                    <span aria-hidden="true">
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                        </svg>
                    </span>
                    <span class="ml-3 text-sm"> Website </span>
                    <span aria-hidden="true" class="ml-auto">
                        <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </a>
                <div x-show="open" x-transition.duration.500ms class="mt-2 ml-2 space-y-2 px-7" role="menu" arial-label="Components">
                    <a href="{{ URL('dashboard/website/order-page/setting') }}" role="menuitem"
                        class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                        Order Pages
                    </a>
                </div>
                <div x-show="open" x-transition.duration.500ms class="mt-2 ml-2 space-y-2 px-7" role="menu" arial-label="Components">
                    <a href="{{ URL('dashboard/layout/banner') }}" role="menuitem"
                        class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                        Slideshow
                    </a>
                </div>
                <div x-show="open" x-transition.duration.500ms class="mt-2 ml-2 space-y-2 px-7" role="menu" arial-label="Components">
                    <a href="{{ URL('dashboard/layout/nav') }}" role="menuitem"
                        class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                        Navigation
                    </a>
                </div>
            </div>

            <!-- Manage Pages links -->
            <div x-data="{ isActive: false, open: false }">
                <!-- active classes 'bg-primary-100 dark:bg-primary' -->
                <a href="" @click="$event.preventDefault(); open = !open"
                    class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                    :class="{ 'bg-primary-100 dark:bg-primary': isActive || open }" role="button" aria-haspopup="true"
                    :aria-expanded="(open || isActive) ? 'true' : 'false'">
                    <span aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                        </svg>
                    </span>
                    <span class="ml-3 text-sm"> Manage Store </span>
                    <span aria-hidden="true" class="ml-auto">
                        <!-- active class 'rotate-180' -->
                        <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </a>
                <div x-show="open" x-transition.duration.500ms class="mt-2 ml-2 space-y-2 px-7" role="menu" arial-label="Pages">
                    <a href="{{ URL('dashboard/products') }}" role="menuitem"
                        class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                        Manage Products
                    </a>
                </div>
                <div x-show="open" x-transition.duration.500ms class="mt-2 ml-2 space-y-2 px-7" role="menu" arial-label="Pages">
                    <a href="{{ URL('dashboard/payment-product') }}" role="menuitem"
                        class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                        Manage Payment Products
                    </a>
                </div>
                <div x-show="open" x-transition.duration.500ms class="mt-2 ml-2 space-y-2 px-7" role="menu" arial-label="Pages">
                    <a href="{{ URL('dashboard/payment-fee') }}" role="menuitem"
                        class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                        Payment Fee
                    </a>
                </div>
                <div x-show="open" x-transition.duration.500ms class="mt-2 ml-2 space-y-2 px-7" role="menu" arial-label="Pages">
                    <a href="{{ URL('dashboard/discount') }}" role="menuitem"
                        class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                        Manage Discount
                    </a>
                </div>
            </div>

            <!-- Authentication links -->
            <div x-data="{ isActive: false, open: false}">
                <!-- active & hover classes 'bg-primary-100 dark:bg-primary' -->
                <a href="#" @click="$event.preventDefault(); open = !open"
                    class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                    :class="{'bg-primary-100 dark:bg-primary': isActive || open}" role="button" aria-haspopup="true"
                    :aria-expanded="(open || isActive) ? 'true' : 'false'">
                    <span aria-hidden="true">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <span class="ml-3 text-sm"> Authentication </span>
                    <span aria-hidden="true" class="ml-auto">
                        <!-- active class 'rotate-180' -->
                        <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </a>
                <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Authentication">
                    <!-- active & hover classes 'text-gray-700 dark:text-light' -->
                    <!-- inActive classes 'text-gray-400 dark:text-gray-400' -->
                    <a href="auth/register.html" role="menuitem"
                        class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:hover:text-light hover:text-gray-700">
                        Register
                    </a>
                    <a href="auth/login.html" role="menuitem"
                        class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:hover:text-light hover:text-gray-700">
                        Login
                    </a>
                    <a href="auth/forgot-password.html" role="menuitem"
                        class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:hover:text-light hover:text-gray-700">
                        Forgot Password
                    </a>
                    <a href="auth/reset-password.html" role="menuitem"
                        class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:hover:text-light hover:text-gray-700">
                        Reset Password
                    </a>
                </div>
            </div>

            <!-- Layouts links -->
            <div x-data="{ isActive: false, open: false}">
                <!-- active & hover classes 'bg-primary-100 dark:bg-primary' -->
                <a href="#" @click="$event.preventDefault(); open = !open"
                    class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                    :class="{'bg-primary-100 dark:bg-primary': isActive || open}" role="button" aria-haspopup="true"
                    :aria-expanded="(open || isActive) ? 'true' : 'false'">
                    <span aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                    <span class="ml-3 text-sm"> Settings </span>
                    <span aria-hidden="true" class="ml-auto">
                        <!-- active class 'rotate-180' -->
                         <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </a>
                <div x-show="open" x-transition.duration.500ms class="mt-2 ml-2 space-y-2" role="menu" aria-label="Layouts">
                    <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" arial-label="Components">
                        <a href="{{ URL('dashboard/settings/seo') }}" role="menuitem"
                            class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                            SEO
                        </a>
                    </div>
                </div>
                <div x-show="open" x-transition.duration.500ms class="mt-2 ml-2 space-y-2" role="menu" aria-label="Layouts">
                    <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" arial-label="Components">
                        <a href="{{ URL('dashboard/settings/provider') }}" role="menuitem"
                            class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                            Marketplace Provider
                        </a>
                    </div>
                </div>
                <div x-show="open" x-transition.duration.500ms class="mt-2 ml-2 space-y-2" role="menu" aria-label="Layouts">
                    <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" arial-label="Components">
                        <a href="{{ URL('dashboard/settings/payment-gateway') }}" role="menuitem"
                            class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                            Payment Gateway
                        </a>
                    </div>
                </div>
                <div x-show="open" x-transition.duration.500ms class="mt-2 ml-2 space-y-2" role="menu" aria-label="Layouts">
                    <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" arial-label="Components">
                        <a href="{{ URL('dashboard/settings/notifications') }}" role="menuitem"
                            class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                            Notification
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar footer -->
        <div class="flex-shrink-0 px-2 py-4 space-y-2">
            <button @click="openSettingsPanel" type="button"
                class="flex items-center justify-center w-full space-x-1 px-4 py-2 text-sm text-white rounded-md bg-primary hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary-dark focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                <span aria-hidden="true">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                </span>
            </button>
        </div>
    </div>
</aside>
