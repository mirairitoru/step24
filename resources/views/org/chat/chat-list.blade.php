<div class="w-full lg:w-1/3 lg:border-r border-black bg-white flex flex-col">
    <div class="px-4">
        <div class="relative mb-4">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-text-gray-400">
                <use href="icons.svg#icon-search"></use>
            </svg>
            <form method="GET" action="{{ route('org.chat.index') }}" class="relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="チャットを検索" class="w-full rounded-lg border px-3
                pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-blue-300">
            </form>
        </div>
        <hr class="border-black">
    </div>

    {{-- チャット一覧 --}}
    <div class="max-h-[700px] overflow-y-auto px-4">
        @forelse ($matches as $match)
            <a href="{{ route('org.chat.show', $match->id) }}" class="flex items-center gap-1 my-4 border hover:bg-orange-100 transition rounded relative">
                {{-- ユーザー画像 --}}
                <div class="shrink-0 bg-gray-200">
                    @if($match->user->image)
                        <img src="{{ asset('storage/' .$match->user->image->path) }}" alt="画像" class="w-14 h-14 rounded object-cover">
                    @else
                        <span class="w-14 h-14 flex items-center justify-center">
                            画像<br>なし
                        </span>
                    @endif
                </div>

                {{-- 名前・動物 --}}
                <div class="flex-1 min-w-0">
                    <div class="flex">
                        <p class="text-sm truncate">
                            {{ $match->user->nickname }}
                        </p>
                        @if($match->unread_count > 0)
                            <span class="absolute top-3 right-4 px-2 py-1 bg-red-500 text-xs text-white rounded-full">
                                {{ $match->unread_count }}
                            </span>
                        @endif
                    </div>
                    <p>{{ $match->animal->animal_name }}</p>
                </div>
            </a>
        @empty
            <div class="py-10 text-gray-400">
                マッチしているユーザーはいません
            </div>
        @endforelse
    </div>
</div>