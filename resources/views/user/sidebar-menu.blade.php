<div class="space-y-4 md:space-y-8 text-gray-700 font-medium">
    <div class="text-lg font-bold text-[#5293FF]">
        【ユーザーマイページ】
    </div>
    <ul class="space-y-8 text-gray-700 font-medium">
        <li>
            <a href="{{ route('mypage.edit') }}"
                class="{{ request()->routeIs('mypage.edit')
                ? 'text-[#5293FF] underline'
                : 'text-gray-700 hover:underline hover:text-[#5293FF]' }}">
                プロフィール編集
            </a>
        </li>
        <li>
            <a href="{{ route('user.mypage') }}" class="hover:underline hover:text-[#5293FF]">
                興味ありリスト一覧
            </a>
        </li>
        <li>
            <a href="{{ route('user.mypage') }}" class="hover:underline hover:text-[#5293FF]">
                マッチした動物一覧
            </a>
        </li>
        <li class="relative">
            <a href="{{ route('user.chat.index') }}" class="hover:underline hover:text-[#5293FF]">
                チャット一覧
            </a>
            @if(isset($totalUnread) && $totalUnread > 0)
                <span class="absolute top-0 right-0 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                    {{ $totalUnread }}
                </span>
            @endif
        </li>
    </ul>
</div>