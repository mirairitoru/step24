<div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
    {{-- ダッシュボード --}}
    <div class="rounded-2xl p-8 shadow-lg">
        <h2 class="text-3xl font-bold text-center mb-10 text-blue-500">
            ダッシュボード
        </h2>

        <div class="space-y-8 text-xl">

            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4 pt-1">
                    <svg class="icon icon-paw w-10 h-10 text-white rounded-full bg-[#5293FF] py-2">
                        <use href="/icons.svg#icon-paw"></use>
                    </svg>
                    <span>登録動物数：</span>
                </div>

                <span class="font-bold">{{ $total }}匹</span>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4 pt-1">
                    <svg class="icon icon-bullhorn w-10 h-10 text-white rounded-full bg-[#F56B01] py-2">
                        <use href="/icons.svg#icon-bullhorn"></use>
                    </svg>
                    <span>募集中：</span>
                </div>

                <span class="font-bold">{{ $available }}</span>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4 pt-1">
                    <svg class="icon icon-handshake-o w-10 h-10 text-white rounded-full bg-[#5293FF] py-2">
                        <use href="/icons.svg#icon-handshake-o"></use>
                    </svg>
                    <span>マッチ中：</span>
                </div>
                <span class="font-bold">{{ $matching }}</span>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4 pt-1">
                    <svg class="icon icon-check w-10 h-10 text-white rounded-full bg-[#F56B01] py-2">
                        <use href="/icons.svg#icon-check"></use>
                    </svg>
                    <span>譲渡完了：</span>
                </div>
                <span class="font-bold text-green-600">
                    {{ $adopted }}
                </span>
            </div>

        </div>

    </div>


    {{-- 通知 --}}
    <div class="rounded-2xl p-10 shadow-lg">
        <h2 class="text-3xl font-bold text-center mb-10 text-[#F56B01]">
            最近の通知
        </h2>
        <div class="space-y-6">
            @forelse($recentNotifications as $notification)
                <div class="border-b pb-4 overflow-hidden text-ellipsis whitespace-nowrap">
                   @if($notification->data['type'] === 'favorite')
                        <span class="text-red-400">❤</span>
                    @elseif($notification->data['type'] === 'match')
                        <span class="text-yellow-400">❤</span>
                    @elseif($notification->data['type'] === 'complete')
                        <span>🐶</span>
                    @endif
                    {{ $notification->data['message'] }}
                </div>
            @empty
                <div class="grid justify-center text-center">
                    <p class="text-lg">
                        通知はありません
                    </p>
                </div>
            @endforelse
        </div>
        @if($recentNotifications->count() > 0)
            <div class="text-center">
                <button id="open-notification-panel" class="text-blue-500 hover:text-blue-700 hover:underline">
                    すべてを見る
                </button>
            </div>
        @endif
    </div>
</div>