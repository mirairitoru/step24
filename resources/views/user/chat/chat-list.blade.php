<div class="w-full lg:w-1/3 lg:border-r border-black bg-white flex flex-col">
    <div class="px-4">
        <div class="relative mb-4">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-text-gray-400">
                <use href="icons.svg#icon-search"></use>
            </svg>
            <form method="GET" action="{{ route('user.chat.index') }}" class="relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="チャットを検索" class="w-full rounded-lg border border-gray-300 px-3 pl-10 pr-4
                    focus:outline-none focus:ring-2 focus:ring-blue-300">
            </form>
        </div>
        <hr class="border-black">
    </div>

    {{-- チャット一覧 --}}
    <div class="max-h-[700px] overflow-y-auto px-4">
        @forelse ($matches as $match)
            <a href="{{ route('user.chat.show', $match->id) }}"
                class="flex items-center gap-1 my-4 border hover:bg-orange-100 transition rounded relative">

                {{-- 保護団体画像 --}}
                <div class="shrink-0 bg-gray-200 rounded">
                    @if($match->animal->organization->image)
                        <img
                            src="{{ asset('storage/'.$match->animal->organization->image->path) }}"
                            alt="画像"
                            class="w-14 h-14 rounded object-cover">
                    @else
                        <span class="w-14 h-14 flex items-center justify-center text-sm">
                            画像<br>なし
                        </span>
                    @endif
                </div>
                {{-- 保護団体名・動物名 --}}
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-center">
                        <p class="text-sm font-semibold truncate py-1">
                            {{ $match->animal->animal_name }}
                        </p>
                        @if($match->unread_count > 0)
                            <span class="absolute top-3 right-4 px-2 py-1 bg-red-500 text-xs text-white rounded-full">
                                {{ $match->unread_count }}
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 truncate">
                        {{ $match->animal->organization->org_name }}
                    </p>
                </div>
            </a>
        @empty
            <div class="py-10 text-gray-400 text-center">
                マッチしている動物はいません
            </div>
        @endforelse
    </div>
</div>