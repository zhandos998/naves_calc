<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->

    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="url('/calc')" :active="request()->is('calc')">
                        Калькулятор 3D
                    </x-nav-link>
                </div>
                {{-- Калькуляторы --}}
                {{-- <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-6">

                    <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    Калькулятор 3D
                                    <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="url('/calc')">
                                    Калькулятор навесов
                                </x-dropdown-link>
                                <x-dropdown-link :href="url('/calcfarm')">
                                    Калькулятор ферм
                                </x-dropdown-link>
                            </x-slot>
                    </x-dropdown>
                </div> --}}
                <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-6">
                    {{-- Навесы --}}
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                Навесы
                                <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="url('/services/naves-arochnyy')">Навес арочный</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/naves-odnoskatnyy')">Навес односкатный</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/poluarochnye-navesy')">Полуарочные навесы</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/naves-iz-polikarbonata')">Навес из поликарбоната</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/naves-dlya-avtomobilya')">Навес для автомобиля</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/naves-pod-klyuch')">Навес под ключ</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/naves-k-domu-iz-polikarbonata')">Навес к дому</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/naves-iz-metallocherepitsy')">Навес из металлочерепицы</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/naves-iz-profnastila')">Навес из профнастила</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/sadovyy-naves')">Садовые навесы</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/naves-iz-myagkoi-cherepitsy')">Навес из мягкой черепицы</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/naves-s-hozblokom')">Навес с хозблоком</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/naves-dlya-dachi')">Навес для дачи</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/naves-dlya-barbekyu')">Навес для барбекю</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/naves-dlya-basseyna')">Навес для бассейна</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/naves-dlya-mangala')">Навес для мангала</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                </div>
                <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-6">
                    {{-- Козырьки --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                Козырьки
                                <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="url('/services/kozyrek-nad-kryltsom')">Козырек над крыльцом</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/kozyrek-iz-polikarbonata')">Козырек из поликарбоната</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/kovanyy-kozyrek')">Кованые козырьки</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                </div>
                <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-6">
                    {{-- Услуги --}}
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                Услуги
                                <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="url('/services/viezd-zamershika')">Выезд замерщика</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/dostavka')">Доставка</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/montazh')">Монтаж навесов</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/demontazh-navesov')">Демонтаж навесов</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/zamena-polikarbonata')">Замена поликарбоната</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/fermy-dlya-navesov')">Фермы для навеса</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/konteynernye-ploschadki')">Контейнерные площадки</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/promoactions')">Акции</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/garanties')">Гарантии и Сертификаты</x-dropdown-link>
                            <x-dropdown-link :href="url('/services/articles')">Статьи</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>
                {{-- Магазин --}}
                {{-- <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-6">
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                Магазин
                                <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="url('/commodities/canopy')">Навесы</x-dropdown-link>
                            <x-dropdown-link :href="url('/commodities/fermi')">Готовые фермы</x-dropdown-link>
                            <x-dropdown-link :href="url('/commodities/kozirki')">Козырьки</x-dropdown-link>
                            <x-dropdown-link :href="url('/commodities/lestnici')">Лестницы</x-dropdown-link>
                            <x-dropdown-link :href="url('/commodities/policarbonat')">Поликарбонат</x-dropdown-link>
                            <x-dropdown-link :href="url('/commodities/profilnye-truby')">Профильные трубы</x-dropdown-link>
                            <x-dropdown-link :href="url('/commodities/kraska')">Краска</x-dropdown-link>
                            <x-dropdown-link :href="url('/commodities/raskhodniki')">Расходные материалы</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div> --}}
                {{-- Отдельные простые ссылки --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="url('/commodities')" :active="request()->is('commodities')">
                        Магазин
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="url('/portfolio')" :active="request()->is('portfolio')">
                        Наши работы
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="url('/reviews')" :active="request()->is('reviews')">
                        Отзывы
                    </x-nav-link>

                </div>
                    {{-- О нас --}}
                <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                О нас
                                <svg class="fill-current h-4 w-4 ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="url('/contacts')">Контакты</x-dropdown-link>
                            <x-dropdown-link :href="url('/vacancies')">Вакансии</x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                </div>


                @role('admin')
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('admin_dashboard')" :active="request()->routeIs('admin_dashboard')">
                            {{ __('Панель администратора') }}
                        </x-nav-link>
                    </div>
                @endrole

            </div>

            <!-- Settings Dropdown -->
            @auth
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @endauth

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('index')" :active="request()->routeIs('index')">
                {{ __('Main') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            @endauth

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
