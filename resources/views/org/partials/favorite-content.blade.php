@if(isset($noAnimals) && $noAnimals)
    {{-- 興味あり動物0匹の時 --}}
    <div class="flex flex-col items-center justify-center h-full text-center">
        <div class="flex gap-6 text-5xl mb-4">
            <svg class="icon icon-paw w-12 h-12 px-1 text-[#5293FF]">
                <use href="/icons.svg#icon-paw"></use>
            </svg>
            <svg class="icon icon-paw w-12 h-12 px-1 text-[#F56B01]">
                <use href="/icons.svg#icon-paw"></use>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-[#F56B01]">興味あり動物はいません</h2>
        <p class="mt-2 text-base leading-relaxed text-[#5293FF]">
            新しいパートナー候補の<br>
            リアクションを待ちましょう！
        </p>
    </div>
@elseif(!$selectedAnimal)
    <div class="flex flex-col items-center justify-center h-full text-center">
        <h2 class="text-xl font-bold">動物を選択してください</h2>
        <p class="mt-2 text-[#5293FF]">左側の興味あり一覧から選択すると<br>動物のリクエストが表示されます</p>
    </div>
@else
    <h2 class="text-center font-bold lg:mb-4">
        {{ $selectedAnimal->animal_name }}のリクエスト
    </h2>

    <div class="flex flex-col md:flex-row gap-2 md:border-t border-black justify-center">
        <div class="sm:w-full md:w-60 h-40 bg-gray-200 flex items-center justify-center my-4">
            @if($selectedAnimal->images->first())
                <img src="{{ asset('storage/' .$selectedAnimal->images->first()->path) }}" alt="イメージ" class="w-full h-40 object-cover rounded">
            @else
                <div class="bg-gray-200 h-40 flex items-center justify-center">
                    画像なし
                </div>
            @endif
        </div>
        <div class="text-left lg:my-4 space-y-3">
            <p class="flex gap-2">名前:<span>{{ $selectedAnimal->animal_name }}</span></p>
            <p class="flex gap-2">種類:<span>{{ $selectedAnimal->species }}</span></p>
            <p class="flex items-center gap-2">
                <span>年齢:</span>
                <span class="flex flex-col leading-tight items-center">
                    <span class="text-sm">{{ $selectedAnimal->age_label }}</span>
                    <span class="text-sm">{{ $selectedAnimal->age_sub }}</span>
                </span>
            </p>
            <p class="flex gap-2">性別:<span>{{ $selectedAnimal->sex }}</span></p>
        </div>
    </div>


    {{-- 興味ありの申請を送ってきたユーザー --}}
    <div class="border-t border-black">
        <h2 class="my-2 font-bold">興味を持っているユーザー</h2>
        @foreach ($favoritedUsers as $favorite)
            <div class="p-2 mb-3 bg-blue-50 flex gap-4 justify-between rounded shadow-lg">
                <div class="w-20 h-20 bg-gray-200 rounded-md overflow-hidden">
                    @if($favorite->user?->image)
                        <img src="{{ asset('storage/' .$favorite->user->image->path) }}" class="w-full h-full object-cover">
                    @else
                        <span class="flex items-center justify-center w-full h-full">
                            画像なし
                        </span>
                    @endif
                </div>

                <div class="flex sm:flex-row items-center justify-between lg:ml-4 flex-1">
                    {{-- 上段 --}}
                    <div class="flex flex-col items-center sm:flex-row gap-4 text-lg sm:justify-evenly">
                        <p>{{ $favorite->user->nickname }}</p>
                        <p>{{ $favorite->user->residence_area }}</p>
                    </div>
                    {{-- 下段 --}}
                    <div class="mt-auto flex flex-col sm:flex-row gap-2 lg:gap-6 justify-evenly">

                        <button type="button"
                            class="open-user-modal w-full sm:w-auto bg-gray-200 px-4 py-2 rounded"
                            data-nickname="{{ $favorite->user->nickname }}"
                            data-residence_area="{{ $favorite->user->residence_area }}"
                            data-user_age="{{ $favorite->user->user_age }}"
                            data-animal_care_experience="{{ $favorite->user->animal_care_experience }}"
                            data-animal_care_details="{{ $favorite->user->animal_care_details }}"
                            data-self_introduction="{{ $favorite->user->self_introduction }}"
                            data-image="{{ $favorite->user->image ? asset('storage/' .$favorite->user->image->path) : '' }}">
                            詳細情報
                        </button>
                        <form method="POST"
                            action="{{ route('org.match.approve', $favorite->id) }}" class="w-full sm:w-auto">
                            @csrf
                            <input type="hidden" name="user_id"
                                value="{{ $favorite->user_id }}">
                            <input type="hidden" name="animal_id"
                                value="{{ $favorite->animal_id }}">

                            <button type="submit"
                                class="w-full bg-red-400 text-white px-4 py-2 rounded">
                                マッチ承認
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        @if ($favoritedUsers instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="flex justify-center">
                {{ $favoritedUsers->links() }}
            </div>
        @endif

        {{-- ユーザーモーダル --}}
        <div id="user-detail-modal"
            class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
            <div class="w-[95%] max-w-[700px]">
                <x-user-profile :user="null" />
            </div>
        </div>
    </div>
@endif