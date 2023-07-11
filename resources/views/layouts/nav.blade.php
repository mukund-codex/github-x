<nav class="flex flex-1 flex-col">
    <ul role="list" class="flex flex-1 flex-col gap-y-7">
        <li>
            <ul role="list" class="-mx-2 space-y-1">
                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                    </svg>
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                    <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                    {{ __('Users') }}
                </x-nav-link>
                <x-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.index')">
                    <svg class="h-6 w-6 shrink-0" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                    {{ __('Roles') }}
                </x-nav-link>
            </ul>
        </li>
        <li class="mt-auto">
            <div x-cloak class="relative inline-flex items-center gap-2 mr-2 mt-2 sm:pb-2">

                <button x-on:click="darkMode = 'light'">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         x-bind:class="{'border-2 border-red/50': darkMode === 'light'}"
                         class="w-6 h-6 p-1 text-gray-700 transition rounded-full cursor-pointer bg-gray-50 hover:bg-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="sr-only">light</span>
                </button>

                <button x-on:click="darkMode = 'dark'">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         x-bind:class="{'border-2 border-red/50': darkMode === 'dark'}"
                         class="w-6 h-6 p-1 text-gray-100 transition bg-gray-700 rounded-full cursor-pointer dark:hover:bg-gray-600" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                    </svg>
                    <span class="sr-only">dark</span>
                </button>

                <button x-on:click="darkMode = 'system'">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        x-cloak
                        x-show="! window.matchMedia('(prefers-color-scheme: dark)').matches"
                        x-bind:class="{'border-2 border-red/50': darkMode === 'system'}"
                        class="w-6 h-6 p-1 text-gray-700 transition bg-gray-100 rounded-full cursor-pointer hover:bg-gray-200"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        x-show="window.matchMedia('(prefers-color-scheme: dark)').matches"
                        x-bind:class="{'border-2 border-red/50': darkMode === 'system'}"
                        class="w-6 h-6 p-1 text-gray-100 transition bg-gray-700 rounded-full cursor-pointer dark:hover:bg-gray-600"
                        x-cloak
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="sr-only">system</span>
                </button>
            </div>
        </li>
    </ul>
</nav>
