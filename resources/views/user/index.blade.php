<div class="bg-gradient-to-r from-blue-100 to-orange-100 mt-6 p-6 rounded-lg shadow-lg">
    <div class="bg-white border border-black p-6 rounded-lg">
        <h2 class="mb-4">ユーザー興味ありリスト</h2>

        @if($favorites->isEmpty())
            <p class="grid min-h-[400px] items-center justify-center relative z-0 text-center">
                <svg class="icon icon-paw w-8 h-8 text-[#5293FF] left-[calc(50%-240px)] top-1/2 -translate-y-1/2 absolute">
                    <use href="/icons.svg#icon-paw"></use>
                </svg>
                <svg class="icon icon-paw w-8 h-8 text-[#5293FF] right-[calc(50%-240px)] top-1/2 -translate-y-1/2 absolute">
                    <use href="/icons.svg#icon-paw"></use>
                </svg>
                あなたが興味ありを申請しているパートナーはいません
            </p>
        @else
            @foreach ($favorites as $favorite)
                <div class="border border-gray-300 p-4 mb-8 
                            flex justify-between items-center gap-4">

                    {{-- 左側 --}}
                    <div class="flex gap-4">
                        <div class="w-24 h-24 bg-gray-200 flex items-center justify-center">
                            @if($favorite->animal->images->first())
                                <img src="{{ asset('storage/' .$favorite->animal->images->first()->path) }}"
                                     alt="イメージ"
                                     class="w-full h-full object-cover rounded">
                            @else
                                <div class="bg-gray-200 h-24 flex items-center justify-center">
                                    画像なし
                                </div>
                            @endif
                        </div>

                        <div class="space-y-1">
                            <p>名前：{{ $favorite->animal->animal_name }}</p>
                            <p>種類：{{ $favorite->animal->species }}</p>
                            <p>年齢：{{ $favorite->animal->age_label }}{{ $favorite->animal->age_sub }}</p>
                            <p>性別：{{ $favorite->animal->sex }}</p>
                        </div>
                    </div>

                    {{-- 右側 --}}
                    <div class="grid grid-cols-1 gap-2 lg:grid-cols-2 lg:gap-4 text-center">

                        {{-- ステータス --}}
                        <div class="bg-blue-500 text-white px-4 py-1">
                            {{ $favorite->status === 'pending' ? '承認待ち' : '承認済み' }}
                        </div>

                        <x-favorite-button :animal="$favorite->animal" />

                        {{-- キャンセル --}}
                        <form action="{{ route('favorites.destroy', $favorite->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('本当に削除しますか？')"
                                class="bg-gray-200 px-4 py-1 rounded w-full sm:w-auto">
                                キャンセル
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif

        <div class="flex justify-center">
            {{ $favorites->links() }}
        </div>
    </div>
</div>

@include('components.modal')