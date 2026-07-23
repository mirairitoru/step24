<div class="w-full lg:w-2/3 lg:ml-4 mt-4 lg:mt-0">
    @if($selectedMatch)  
        <div class="flex flex-col bg-white lg:h-full h-[650px] lg:max-h-[650px]">
            <div class="flex items-center px-6 py-2 border-b border-black bg-white">
                <div class="flex items-start">
                    <a href="{{ route('org.chat.index', $selectedMatch->id) }}" class="hover:text-blue-100 lg:hidden">
                        <svg class="icon icon-reply w-8 h-8 text-blue-400">
                            <use href="/icons.svg#icon-reply"></use>
                        </svg>
                    </a>
                </div>
                {{-- 里親希望者 --}}
                <div class="flex flex-1 items-center justify-center gap-4">
                    @if ($selectedMatch->user->image)
                        <img src="{{ asset('storage/'.$selectedMatch->user->image->path) }}" alt="画像"
                        class="w-14 h-14 rounded-full object-cover border bg-gray-200">
                    @else
                        <span class="w-14 h-14 text-sm flex items-center justify-center bg-gray-200 rounded-full">
                            画像<br>なし
                        </span>
                    @endif

                    <div class="flex flex-col items-center">
                        <p class="text-lg font-semibold">
                            {{ $selectedMatch->user->nickname }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $selectedMatch->user->user_age }}
                        </p>
                    </div>
                </div>
            </div>
            {{-- チャット内容 --}}
            <div id="message-area" class="h-full overflow-y-auto p-4 space-y-3 bg-blue-50">
                @foreach ($messages as $message)
                    {{-- 保護団体メッセージ --}}
                    @if ($message->sender_type === 'organization')
                        <div class="flex justify-end gap-2">
                            <p class="flex items-end text-xs text-gray-400">
                                {{ $message->created_at->format('H:i') }}
                            </p>
                            <div class="max-w-[70%]">
                                <div class="bg-[#8FD3FF] rounded-2xl px-3 py-2">
                                    {{ $message->message }}
                                </div>
                            </div>
                        </div>
                    {{-- ユーザーメッセージ --}}
                    @else
                        <div class="flex justify-start gap-2">
                            @if($selectedMatch->user->image)
                                <img src="{{ asset('storage/'.$selectedMatch->user->image->path) }}" alt="画像" class="w-10 h-10 rounded-full
                                object-cover border">
                            @else
                                <span class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-200 text-xs">
                                    画像<br>なし
                                </span>
                            @endif
                            <div class="max-w-[70%]">
                                <div class="bg-white border rounded-2xl px-3 py-2">
                                    {{ $message->message }}
                                </div>
                            </div>
                            <div class="text-center relative">
                                @if($message->isReadBy('organization'))
                                    <span class="text-xs text-blue-500">
                                        既読
                                    </span>
                                @endif
                                <p class="absolute top-5 left-0 text-xs text-gray-400">
                                    {{ $message->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="border-t border-black">
                <form action="{{ route('org.chat.store', $selectedMatch) }}" method="POST" class="flex items-center gap-2 mt-5">
                    @csrf
                    <input type="text" name="message" placeholder="メッセージを入力してください" class="flex-1 border rounded px-3 py-2
                    focus:ring-2 focus:ring-blue-400">
                    <button class="ml-3 px-4 py-2 bg-blue-500 text-white rounded">
                        送信
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center h-full mx-auto">
            <h2 class="text-xl font-semibold">
                チャットを選択してください
            </h2>
            <p class="mt-2 text-[#5293FF]">
                左側のチャット一覧から選択すると<br>
                メッセージを表示できます。
            </p>
        </div>
    @endif
    @if ($selectedMatch)
        <script>
            window.chatId = {{ $selectedMatch->chat->id }};
        </script>
    @endif
</div>
