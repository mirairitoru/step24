<header class="mt-4">
    <nav class="flex mt-4 max-w-7xl mx-auto">
        <div>
            @include('auth.partials.logo', ['route' => 'animals', 'colorType' => 'header'])
        </div>

        <!-- PC用ナビ -->
        <div class="hidden md:flex mt-4 ml-auto space-x-24 mr-8 font-bold text-2xl">
            <a href="{{ route('animals') }}"
                class="{{ request()->routeIs('animals')
                ? 'text-blue-600 underline'
                : 'text-gray-900 hover:text-blue-600 hover:underline' }}">
                TOP
            </a>

            @auth('web')
                <a href="{{ route('user.mypage') }}"
                    class="{{ request()->routeIs('user.mypage')
                    ? 'text-blue-600 underline'
                    : 'text-gray-900 hover:text-blue-600 hover:underline'}}">
                    マイページ
                </a>
            @endauth

            @auth('org')
                <a href="{{ route('org.mypage') }}"
                    class="{{ request()->routeIs('org.mypage')
                    ? 'text-blue-600 underline'
                    : 'text-gray-900 hover:text-blue-600 hover:underline'}}">
                    マイページ
                </a>
            @endauth

            @auth('web')
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="hover:text-blue-600 hover:underline text-gray-900">ログアウト</button>
                </form>
            @endauth

            @auth('org')
                <form method="POST" action="{{ route('org.logout') }}">
                    @csrf
                    <button class="hover:text-blue-600 hover:underline text-gray-900">ログアウト</button>
                </form>
            @endauth
        </div>

        <!-- ハンバーガー -->
        <button id="menu-btn" class="md:hidden text-3xl focus:outline-none mx-auto hover:text-[#5293FF]">
            ☰
        </button>
    </nav>
    <hr class="mt-4">
</header>

<!-- オーバーレイ -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-40 hidden z-40"></div>

<!-- モバイルメニュー（左画面外からスライドイン） -->
<nav id="mobile-menu" class="fixed top-0 left-0 w-64 max-h-full bg-white border-4 border-blue-500 p-6  pl-4
        transform -translate-x-full transition-transform duration-300 md:hidden z-50 shadow-xl rounded-xl">

    <h2 class="text-lg font-semibold text-blue-600 mb-4">メニュー</h2>

    <ul class="space-y-4 text-gray-700 mb-10">
        <li>
            <a href="{{ route('animals') }}"
                class="{{ request()->routeIs('animals')
                ? 'text-blue-600 underline'
                : 'text-gray-900 hover:text-blue-600 hover:underline' }}">
                TOP
            </a>
        </li>

        @auth('web')
        <li>
            <a href="{{ route('user.mypage') }}"
                class="{{ request()->routeIs('user.mypage')
                ? 'text-blue-600 underline'
                : 'text-gray-900 hover:text-blue-600 hover:underline'}}">
                マイページ
            </a>
        </li>
        @endauth

        @auth('org')
        <li>
            <a href="{{ route('org.mypage') }}"
                class="{{ request()->routeIs('org.mypage')
                ? 'text-blue-600 underline'
                : 'text-gray-900 hover:text-blue-600 hover:underline'}}">
                マイページ
            </a>
        </li>
        @endauth

        @auth('web')
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="hover:text-blue-600 hover:underline text-gray-900">ログアウト</button>
            </form>
        </li>
        @endauth

        @auth('org')
        <li>
            <form method="POST" action="{{ route('org.logout') }}">
                @csrf
                <button class="hover:text-blue-600 hover:underline text-gray-900">ログアウト</button>
            </form>
        </li>
        @endauth
    </ul>
    @auth('web')
        @include('user.sidebar-menu')
    @endauth
    @auth('org')
        @include('org.sidebar-menu')
    @endauth
</nav>