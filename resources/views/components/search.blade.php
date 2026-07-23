<form method="GET" action="{{ route('animals') }}" class="max-w-7xl mx-auto bg-white rounded-3xl shadow-xl p-5 md:p-12">

    {{-- 名前検索 --}}
    <div class="flex flex-col md:flex-row md:items-center gap-4">
        <div class="w-full md:w-56 flex items-center gap-4 shrink-0">
            <div class="w-16 h-16 rounded-full bg-blue-50 flex justify-center items-center">
                <svg class="icon icon-search w-8 h-8 text-blue-400">
                    <use href="icons.svg#icon-search"></use>
                </svg>
            </div>
            <p class="mr-4 text-xl">名前:</p>
        </div>
        <input type="text" name="keyword" placeholder="名前検索" value="{{ request('keyword') }}" class="w-full border rounded-xl px-4 py-3 text-base md:text-xl">
    </div>

    {{-- 種類 --}}
    <div class="flex justify-start items-center text-lg py-6">
        <div class="w-56 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-green-50 flex justify-center items-center">
                <svg class="icon icon-paw w-8 h-8 text-green-400">
                    <use href="/icons.svg#icon-paw"></use>
                </svg>
            </div>
            <p class="mr-4 text-xl">種類:</p>
        </div>
        @php
            $selectedSpecies = request('species', [])
        @endphp
        <div class="flex flex-wrap gap-6 md:gap-8">
            @foreach(['犬', '猫', 'その他'] as $species)
                <label class="cursor-pointer">
                    <input type="checkbox" name="species[]" value="{{ $species }}" class="hidden peer flex-1" @checked(in_array($species, $selectedSpecies))>
                    <span class="py-2 px-4 text-lg md:text-base border rounded-xl peer-checked:bg-green-50 peer-checked:border-green-400">
                        {{ $species }}
                    </span>
                </label>
            @endforeach
        </div>
    </div>

    {{-- 年齢 --}}
    <div class="flex justify-start items-center pb-6 text-lg">
        <div class="w-56 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-orange-50 flex justify-center items-center">
                <svg class="icon icon-calendar w-8 h-8 text-orange-400">
                    <use href="icons.svg#icon-calendar"></use>
                </svg>
            </div>
            <p class="mr-4 text-xl">年齢:</p>
        </div>
        <div class="grid grid-cols-2 md:flex gap-4 md:gap-14">
            @foreach ([
                'growth' => '成長(0~1歳)',
                'youth' => '青年(2~5歳)',
                'adult' => '中年(6~9歳)',
                'senior' => 'シニア(10歳以上)',
            ] as $value => $label)

            <label class="cursor-pointer">
                <input type="radio" name="age" value="{{ $value }}" @checked(request('age', '')==$value)>
                <span>{{ $label }}</span>
            </label>     
            @endforeach
        </div>
    </div>

    {{-- 性別 --}}
    <div class="flex justify-start items-center pb-6 text-lg">
        <div class="w-56 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-pink-50 flex justify-center items-center">
                <svg class="icon icon-heart w-8 h-8 text-pink-400">
                    <use href="icons.svg#icon-heart"></use>
                </svg>
            </div>
            <p class="mr-4">性別:</p>
        </div>
        <div class="flex flex-wrap gap-6 md:gap-28">
            @foreach ([
                'オス' => 'オス',
                'メス' => 'メス',
                'その他' => 'その他'
            ] as $value => $label)

            <label class="cursor-pointer">
                <input type="radio" name="sex" value="{{ $value }}" @checked(request('sex', '')== $value)>
                <span>{{ $label }}</span>
            </label>
                
            @endforeach
        </div>
    </div>

    {{-- 性格 --}}
    <div class="flex justify-start pb-6 text-lg">
        <div class="w-56 flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-purple-50 flex justify-center items-center">
                <svg class="icon icon-star-full w-8 h-8 text-purple-400">
                    <use href="icons.svg#icon-star-full"></use>
                </svg>
            </div>
            <p class="mr-4 text-xl">性格：</p>
        </div>
        @php
            $selected = request('personality', []);
        @endphp
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 md:gap-8">
            @foreach(['穏やか', '人懐っこい', 'おっとり', '好奇心旺盛', '臆病', '甘えん坊', 'マイペース', '食いしん坊'] as $p)
                <label class="cursor-pointer text-start">
                    <input type="checkbox" name="personality[]" value="{{ $p }}" class="hidden peer" @checked(in_array($p, $selected))>
                    <span class="py-2 px-4 border text-sm md:text-base rounded-xl peer-checked:bg-purple-50 peer-checked:border-purple-400">
                        {{ $p }}
                    </span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="flex flex-col sm:flex-row justify-center gap-4 mt-6">
        {{-- 検索 --}}
        <button type="submit" class="w-full sm:w-auto rounded-3xl px-6 py-3 bg-[#5293FF] text-white">
            <div class="flex items-center justify-center gap-2">
                <svg class="icon icon-search w-5 h-5 text-white">
                    <use href="icons.svg#icon-search"></use>
                </svg>
                検索する
            </div>
        </button>
        {{-- リセット --}}
        <a href="{{ route('home') }}" class="w-full sm:w-auto text-center rounded-3xl px-6 py-3 bg-[#F56B01] text-white">
            <div class="flex items-center justify-center gap-2">
                <svg class="icon icon-reload w-6 h-6">
                    <use href="icons.svg#icon-reload"></use>
                </svg>
                条件クリア
            </div>
        </a>
    </div>
</form>