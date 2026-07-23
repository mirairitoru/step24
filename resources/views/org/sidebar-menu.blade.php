<div class="space-y-4 md:space-y-8 text-gray-700 font-medium">
    <div class="text-lg font-bold text-[#5293FF]">
        【団体マイページ】
    </div>
    <ul class="space-y-8 text-gray-700 font-medium">
        <li>
            <a href="{{ route('org.mypage') }}" class="hover:underline hover:text-[#5293FF]">ダッシュボード</a>
        </li>
        <li>
            <a href="{{ route('org.animals.create') }}"
                class="{{ request()->routeIs('org.animals.create')
                ? 'text-[#5293FF] underline'
                : 'text-gray-700 hover:underline hover:text-[#5293FF]' }}">
                保護動物登録
            </a>
        </li>
        <li>
            <a href="{{ route('org.mypage') }}" class="hover:underline hover:text-[#5293FF]">保護動物一覧</a>
        </li>
        <li>
            <a href="{{ route('org.favorite.index') }}"
                class="{{ request()->routeIs('org.favorite.index') 
                ? 'text-[#5293FF] underline'
                : 'text-gray-700 hover:underline hover:text-[#5293FF]' }}">
                マッチ管理
            </a>
        </li>
        <li class="relative">
            <a href="{{ route('org.chat.index') }}"
                class="{{ request()->routeIs('org.chat.index')
                ? 'text-[#5293FF] underline'
                : 'text-gray-700 hover:underline hover:text-[#5293FF]' }}">
                チャット一覧
            </a>
            @if(isset($totalUnread) && $totalUnread > 0)
                <span class="absolute top-0 right-0 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                    {{ $totalUnread }}
                </span>
            @endif
        </li>
        <li>
            <a href="{{ route('org.mypage.edit') }}"
                class="{{ request()->routeIs('org.mypage.edit')
                ? 'text-[#5293FF] underline'
                : 'text-gray-700 hover:underline hover:text-[#5293FF]' }}">
                団体情報編集
            </a>
        </li>
    </ul>
</div>

