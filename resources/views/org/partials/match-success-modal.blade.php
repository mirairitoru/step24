@if (session('match_success'))
    <div id="match-modal"
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white w-[500px] p-8 relative">
            {{-- 閉じる --}}
            <button id="close-match-modal" class="absolute top-3 right-3 text-xl font-bold hover:red-500">
                x
            </button>
            <h2 class="text-2xl font-bold text-center mb-6">
                マッチが成立しました<span class="text-red-500">❤</span>
            </h2>
            <p class="text-center mb-8 font-bold">
                このユーザーとチャットを開始しますか？
            </p>
            <div class="space-y-6">
                <a href="{{ route('org.chat.index') }}" class="block w-full bg-blue-500 text-white text-center py-3">
                    チャットを開始する
                </a>
                <button id="later-match-button" class="w-full bg-gray-200 py-3">
                    後で対応する
                </button>
            </div>
        </div>
    </div>
@endif