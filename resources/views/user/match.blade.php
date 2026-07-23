<div class="bg-gradient-to-r from-orange-100 to-blue-100 mt-6 p-6 rounded-lg shadow-lg">
    <div class="bg-white border border-black p-6 rounded-lg">
        <h2 class="font-bold mb-4">マッチした動物</h2>
        @if($matches->isEmpty())
            <div class="grid min-h-[400px] items-center justify-center relative z-0">
                <svg class="icon icon-paw w-8 h-8 text-[#F56B01] left-[calc(50%-210px)] top-1/2 -translate-y-1/2 absolute">
                    <use href="/icons.svg#icon-paw"></use>
                </svg>
                <p>
                    あなたがマッチしているパートナーはいません
                </p>
                <svg class="icon icon-paw w-8 h-8 text-[#F56B01] right-[calc(50%-210px)] top-1/2 -translate-y-1/2 absolute">
                    <use href="/icons.svg#icon-paw"></use>
                </svg>
            </div>
        @else
            @foreach ($matches as $match)
                <div class="border p-4 mb-8 flex justify-between items-center">
                    {{-- 左側 --}}
                    <div class="flex">
                        <div class="w-24 h-24 bg-gray-200 flex items-center justify-center">
                            @if($match->animal->images->first())
                                <img src="{{ asset('storage/' .$match->animal->images->first()->path) }}" alt="イメージ" class="w-full h-24 object-cover rounded">
                            @else
                                <div class="bg-gray-200 h-24 flex items-center justify-center">
                                    画像なし
                                </div>
                            @endif
                        </div>
                        <div class="ml-4">
                            <p>名前：{{ $match->animal->animal_name }}</p>
                            <p>種類：{{ $match->animal->species }}</p>
                            <p>年齢：{{ $match->animal->age_label }}{{ $match->animal->age_sub }}</p>
                            <p>性別：{{ $match->animal->sex }}</p>
                        </div>
                    </div>
                    {{-- 右側 --}}
                    <div class="grid grid-cols-1 gap-2 lg:grid-cols-2 lg:gap-4 text-center">

                        {{-- ステータス --}}
                        <div class="{{ $match->status === '譲渡完了' ? 'bg-red-500' : 'bg-blue-500' }} text-white px-4 py-1 w-30">
                            {{ $match->status === '譲渡準備中' ? '譲渡準備中' : '譲渡完了' }}
                        </div>

                        <x-match-animal :match="$match" />

                        {{-- チャット一覧 --}}
                        {{-- @if($match->status !== '譲渡完了') --}}
                            <a href="{{ route('user.chat.show', $match->id) }}" class="bg-gray-200 px-4 py-1 w-30 inline-flex items-center justify-center">
                                チャットへ >
                            </a>
                        {{-- @endif --}}
                        {{-- キャンセル --}}
                        <form action="{{ route('matches.destroy', $match->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            @if($match->status !== '譲渡完了')
                                <button type="submit"
                                    class="bg-gray-200 px-4 py-1 w-30"
                                    onclick="return confirm('本当に削除しますか？')"
                                    >
                                    キャンセル
                                </button>
                            @endif
                        </form>
                    </div>
                </div>          
            @endforeach
        @endif
        <div class="flex items-center justify-center">
            {{ $matches->links() }}
        </div>
    </div>
</div>