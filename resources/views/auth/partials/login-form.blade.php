<div class="w-full">
    <!-- タブ -->
    <div class="mb-4 flex justify-center space-x-24">
        <button type="button" id="login-btn-user"
            class="tab-btn px-4 pb-3 pt-2 text-[#F56B01] hover:text-[#5293FF] text-xl font-semibold">
            一般ユーザー
        </button>

        <button type="button" id="login-btn-org"
            class="tab-btn px-4 pb-3 pt-2 text-[#F56B01] hover:text-[#5293FF] text-xl font-semibold">
            保護団体
        </button>
    </div>

    <!-- ユーザーフォーム -->
    <form id="userForm" method="POST" action="{{ route('user.login') }}" novalidate>
        @csrf

        <input type="hidden" name="role" value="user">
        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="user-email" class="!text-[#5293FF] text-lg" :value="__('Email')" />
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[#5293FF] icon icon-mail">
                    <use href="/icons.svg#icon-mail"></use>
                </svg>
                <x-text-input id="user-email" onfocus="checkLoginTabSelected()" class="block mt-1 w-full !border-[#5293FF] !pl-10 rounded-lg px-4 py-3 text-lg" type="email" name="email" placeholder="メールアドレス"/>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 mb-4">
            <x-input-label for="user-password" class="!text-[#5293FF] text-lg" :value="__('Password')" />
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[#5293FF] icon icon-key">
                    <use href="/icons.svg#icon-key"></use>
                </svg>
                <x-text-input id="user-password" onfocus="checkLoginTabSelected()" class="block mt-1 w-full !border-[#5293FF] !pl-10 rounded-lg px-4 py-3 text-lg" type="password" name="password" placeholder="パスワード"/>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-primary-button type="submit" class="w-full justify-center mt-3 !bg-[#5293FF] hover:!bg-[#7AB4FF] transtistion-colors duration-200 rounded-lg px-4 py-3 !text-lg">
            {{ __('ログイン') }}
        </x-primary-button>
    </form>

    <!-- 保護団体 --->
    <form id="orgForm" class="hidden" method="POST" action="{{ route('org.login') }}" novalidate>
        @csrf

        <input type="hidden" name="role" value="org">
        <!-- Email Address -->
        <div class="mb-4">
            <x-input-label for="org-email" class="!text-[#5293FF] text-lg" :value="__('Email')" />
            <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[#5293FF] icon icon-mail">
                <use href="/icons.svg#icon-mail"></use>
            </svg>
                <x-text-input id="org-email" onfocus="checkLoginTabSelected()" class="block mt-1 w-full !border-[#5293FF] !pl-10 rounded-lg px-4 py-3 text-lg" type="email" name="email" placeholder="メールアドレス"/>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 mb-4">
            <x-input-label for="org-password" class="!text-[#5293FF] text-lg" :value="__('Password')" />
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-[#5293FF] icon icon-key">
                    <use href="/icons.svg#icon-key"></use>
                </svg>
                <x-text-input id="org-password" onfocus="checkLoginTabSelected()" class="block mt-1 w-full !border-[#5293FF] !pl-10 rounded-lg px-4 py-3 text-lg" type="password" name="password" placeholder="パスワード"/>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <x-primary-button type="submit" class="w-full justify-center mt-3 !bg-[#5293FF] hover:!bg-[#7AB4FF] transtistion-colors duration-200 rounded-lg px-4 py-3 !text-lg">
            {{ __('ログイン') }}
        </x-primary-button>
    </form>

    <div id="popup-message" class="hidden fixed inset-0 items-center justify-center rounded-lg bg-black/30 z-50">
        <div id="popup-box" class="absolute top-40 left-1/2 -translate-x-1/2 duration-[500ms]
            bg-white px-6 py-4 rounded-lg shadow-xl text-center text-lg font-semibold text-red-500 w-[360px]">
            <span id="popup-text"></span>
        </div>
    </div>
</div>