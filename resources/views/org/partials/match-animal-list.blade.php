{{-- 左側タブ --}}
<div class="w-full lg:w-1/3 border-b lg:border-b-0 lg:border-r border-black">
    <div class="px-4">
        <div class="flex flex-col sm:flex-row gap-4 mb-4">
            <button class="w-full sm:w-auto border bg-blue-200 hover:text-white hover:bg-blue-500 px-2 py-2 text-sm rounded-md"
                onclick="window.location.href='{{ route('org.favorite.index') }}'">
                興味あり一覧
            </button>
            <button class="w-full sm:w-auto border hover:text-white hover:bg-blue-500 px-2 py-2 text-sm rounded-md
                {{ request()->routeIs('org.match.index') ? 'bg-blue-500 text-white' : 'bg-blue-200' }}"
                onclick="window.location.href='{{ route('org.match.index') }}'">
                マッチ中一覧
            </button>
        </div>
        <hr class="hidden md:block border-black mb-4">
    </div>

    <div class="max-h-[350px] lg:max-h-[650px] overflow-y-auto px-4">
        @foreach ($animals as $animal)
            <a href="{{ route('org.match.index', [
                'animal_id' => $animal->id,
            ]) }}"
                class="w-full flex items-center gap-4 p-2 mb-4 border rounded relative hover:bg-orange-100 hover:border-orange-300 cursor-pointer
                    {{ request('animal_id') == $animal->id ? 'bg-orange-100' : '' }}">
                @if($animal->images->first())
                    <img src="{{ asset('storage/' .$animal->images->first()->path) }}" alt="画像" class="w-14 h-14 sm:w-16 sm:h-16 object-cover rounded">
                @else
                    <div class="bg-gray-200 w-14 h-14 sm:w-16 sm:h-16 flex items-center justify-center">
                        画像なし
                    </div>
                @endif 
                <div class="ml-2 text-center">
                    <p class="font-bold mb-1">{{ $animal->animal_name }}</p>
                    <p class="text-xs font-bold">
                        {{ $animal->matche->first()?->status }}
                    </p>
                </div>
                <span class="bg-blue-500 text-white text-xs px-2 py-1 absolute top-0 right-0">
                    マッチ中
                </span>
            </a>
        @endforeach
    </div>
</div>