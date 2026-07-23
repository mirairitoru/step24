@if(isset($noAnimals) && $noAnimals)
    <div class="flex flex-col items-center justify-center h-full text-center text-gray-400">
        <div class="text-5xl mb-4 text-red-400">
            ❤
        </div>
        <h2 class="text-2xl font-bold text-[#F56B01]">マッチ中の動物はいません</h2>
        <p class="mt-4 text-base leading-relaxed text-[#5293FF]">
            新しいパートナー候補との<br>
            マッチを期待しましょう！
        </p>
    </div>
@elseif(!$selectedAnimal)
    <div class="flex flex-col items-center justify-center h-full text-center">
        <h2 class="text-xl font-bold">動物を選択してください</h2>
        <p class="mt-2 text-[#5293FF]">左側のマッチ中一覧から選択すると<br>動物のリクエストが表示されます</p>
    </div>
@else
    <h2 class="font-bold text-center mt-2">
        マッチ一覧
    </h2>
    <div class="md:border-t border-black md:my-4 min-h-0">
        @foreach ($matchedUsers as $match)
            {{-- マッチした動物 --}}
            <div class="grid md:flex md:gap-4 justify-center">
                <div class="w-full md:w-60 h-40 bg-gray-200 flex items-center justify-center mx-4 my-4">
                    @if($selectedAnimal->images->first())
                        <img src="{{ asset('storage/' .$selectedAnimal->images->first()->path) }}" alt="イメージ" class="w-full h-40 object-cover rounded">
                    @else
                        <div class="bg-gray-200 h-40 flex items-center justify-center">
                            画像なし
                        </div>
                    @endif
                </div>
                <div class="mb-4 md:my-4 space-y-1 flex flex-col text-center md:text-left">
                    <p class="flex gap-2">
                        名前:<span>{{ $match->animal->animal_name }}</span></p>
                    <p class="flex gap-2">種類:<span>{{ $match->animal->species }}</span></p>
                    <p class="flex items-center gap-2">
                        <span>年齢:</span>
                        <span class="flex flex-col leading-tight items-center">
                            <span class="text-sm">{{ $match->animal->age_label }}</span>
                            <span class="text-sm">{{ $match->animal->age_sub }}</span>
                        </span>
                    </p>
                    <p class="flex gap-2">性別:<span>{{ $match->animal->sex }}</span></p>
                    @include('components.match-animal')
                </div>
            </div>
            {{-- マッチしたユーザー --}}
            <div class="border-y border-black flex flex-col lg:flex-row items-center justify-evenly gap-2 py-2 lg:gap-4 lg:py-2">
                <div class="grid mt-4">
                    <h2 class="font-bold gap-4 md:text-center">マッチ中ユーザー情報</h2>
                    <div class="flex gap-2 items-center">
                        <div class="w-60 h-40 md:w-20 md:h-20 bg-gray-200 my-4">
                            @if($match->user?->image)
                                <img src="{{ asset('storage/' .$match->user->image->path) }}" class="w-full h-full object-cover rounded">
                            @else
                                <span class="flex items-center justify-center w-full h-full">
                                    画像なし
                                </span>
                            @endif
                        </div>
                        <div class="space-y-4 my-4 md:text-sm md:space-y-0">
                            <p class="text-sm">ニックネーム:{{ $match->user->nickname }}</p>
                            <p class="text-sm">居住エリア:{{ $match->user->residence_area }}</p>
                            <p class="text-sm">年齢:{{ $match->user->user_age }}</p>
                            @include('components.match-user')
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-auto space-y-2">
                    <h2 class="md:text-center ml-6 font-bold">進行管理</h2>
                    <div class="md:ml-6 mt-2">
                        <form method="POST" action="{{ route('org.match.status.update', $match->id) }}" class="space-y-1">
                            @csrf
                            @method('PATCH')
                            <label class="flex items-center gap-2">
                                <input
                                    type="radio"
                                    name="status"
                                    value="譲渡準備中"
                                    {{ $match->status === '譲渡準備中' || !$match->status ? 'checked' : '' }}
                                >
                                <span>譲渡準備中</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input
                                    type="radio"
                                    name="status"
                                    value="譲渡完了"
                                    {{ $match->status === '譲渡完了' ? 'checked' : '' }}
                                >
                                <span>譲渡完了</span>
                            </label>
                            <button type="submit" class="border bg-green-700 border-green-700 text-white rounded w-full">
                                保存
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        <div id="user-detail-modal"
            class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
            <div class="w-[95%] md:w-[700px]">
                <x-user-profile :user="null" />
            </div>
        </div>
    </div>
    @include('components.modal')
    <h2 class="font-bold">進行状況</h2>
    <div class="bg-blue-50 shoadow-lg overflow-y-auto p-2 max-h-[180px] lg:max-h-[200px] min-h-0">
        @forelse($timelines as $timeline)
            <div class="flex flex-col sm:flex-row sm:items-center border-l-4 border-blue-500 pl-4 pb-2 gap-1">
                <p class="text-sm text-gray-500 sm:pr-4">
                    {{ \Carbon\Carbon::parse($timeline['date'])->format('Y/m/d H:i') }}
                </p>
                <p class="text-gray-800">
                    {{ $timeline['text'] }}
                </p>
            </div>
        @empty
            <p class="text-gray-400">
                進行状況はありません
            </p>
        @endforelse
    </div>
@endif