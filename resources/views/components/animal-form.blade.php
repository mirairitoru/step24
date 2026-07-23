<form method="POST" action="{{ $action }}">
    @csrf

    @if($method === 'PUT')
        @method('PUT')
    @endif
    {{-- 名前 --}}
    <div class="grid md:grid-cols-[125px_1fr] gap-y-4 gap-x-4">
        <label for="animal_name" class="text-center pt-2 pr-2">名前：</label>
        <div class="mb-4">
            <input type="text" name="animal_name" id="animal_name" value="{{ old('animal_name', $animal->animal_name ?? '') }}" class="w-full rounded py-3 @error('animal_name') border-red-500 @enderror">
            <div class="min-h-[10px] mt-2">
                @error('animal_name')
                    <p class="text-red-500 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        {{-- 種類 --}}
        <p class="text-center pr-2">種類：</p>
        <div class="mb-4">
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-4">
                @foreach (['犬', '猫', 'その他'] as $species)
                    <label class="flex items-center gap-2">
                        <input type="radio" name="species" value="{{ $species }}"
                            class="@error('species') border-red-500 @enderror"
                            {{ old('species', $animal->species ?? '') === $species ? 'checked' : '' }}>
                        <span>{{ $species }}</span>
                    </label>
                @endforeach
            </div>
            <div class="min-h-[10px] mt-2">
                @error('species')
                    <p class="text-red-500 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        {{-- 年齢 --}}
        <p class="text-center pr-2 pt-2">年齢：</p>
        <div class="mb-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                @foreach([
                    ['label' => '成長', 'sub' => '(0~1歳)', 'value' => 'growth'],
                    ['label' => '青年', 'sub' => '(2~5歳)', 'value' => 'youth'],
                    ['label' => '中年', 'sub' => '(6~9歳)', 'value' => 'adult'],
                    ['label' => 'シニア', 'sub' => '(10歳以上)', 'value' => 'senior'],
                ] as $age)
                    <label class="flex items-center gap-2">
                        <input type="radio" name="age" value="{{ $age['value'] }}"
                            class="@error('age') border-red-500 @enderror"
                            {{ old('age', $animal->age ?? '') === $age['value'] ? 'checked' : '' }}>
                        <span class="leading-tight">
                            <span>{{ $age['label'] }}</span>
                            <span class="text-sm block">{{ $age['sub'] }}</span>
                        </span>
                    </label>
                @endforeach
            </div>
            <div class="min-h-[10px] mt-2">
                @error('age')
                    <p class="text-red-500 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        {{-- 性別 --}}
        <p class="text-center pr-2">性別：</p>
        <div class="mb-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                @foreach(['オス', 'メス', 'その他'] as $sex)
                    <label class="flex items-center gap-2">
                        <input type="radio" name="sex" value="{{ $sex }}"
                            class="@error('sex') border-red-500 @enderror"
                            {{ old('sex', $animal->sex ?? '') === $sex ? 'checked' : '' }}>
                        <span>{{ $sex }}</span>
                    </label>
                @endforeach
            </div>
            <div class="min-h-[10px] mt-2">
                @error('sex')
                    <p class="text-red-500 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        {{-- 性格 --}}
        <p class="text-center pr-2">性格：</p>

        @php
            $selected = old('personality', isset($animal) ? $animal->personality : []);
        @endphp

        <div class="mb-4">
            <div class="grid grid-cols-2 sm:gird-cols-3 md:grid-cols-4 gap-y-8">
                @foreach(['穏やか', '人懐っこい', 'おっとり', '好奇心旺盛', '臆病', '甘えん坊', 'マイペース', '食いしん坊'] as $p)
                    <label class="cursor-pointer text-start">
                        <input type="checkbox" name="personality[]" value="{{ $p }}" class="hidden peer"
                            {{ in_array($p, $selected) ? 'checked' : ''}}>
                        <span class="py-2 px-2 rounded-xl border peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-checked:text-white">
                            {{ $p }}
                        </span>
                    </label>
                @endforeach
            </div>
            <div class="min-h-[10px] mt-2">
                @error('personality')
                    <p class="text-red-500 text-sm">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        {{-- 健康状態 --}}
        <label for="health_status" class="text-center pr-2 mt-2 rounded">健康状態：</label>
        <div class="mb-4">
            <input type="text" name="health_status" id="health_status" value="{{ old('health_status', $animal->health_status ?? '') }}" class="w-full rounded">
        </div>
        {{-- コメント --}}
        <label for="comment" class="text-center pr-2 mt-2">コメント：</label>
        <div class="mb-6">
            <input type="text" name="comment" id="comment" value="{{ old('comment', $animal->comment ?? '') }}" class="w-full">
        </div>
        {{-- 動物画像 --}}
        <label class="pr-2 text-center">TOP画像:</label>

        <label for="animalImageInput" 
            class="w-full h-32 md:h-40 overflow-hidden rounded border bg-blue-50 cursor-pointer
            hover:bg-gray-50 flex items-center justify-center relative">

            {{-- アップロード枠 --}}
            <div id="animalPlaceholder" class="w-full h-32 md:h-40 flex items-center gap-2 justify-center border-2 border-dashed border-[#5293FF]">
                <span class="text-blue-500 text-center">
                    画像をアップロード
                </span>    
            </div>

            <input type="file" id="animalImageInput" accept="image/*" class="hidden">
        </label>

        <input type="hidden" name="animalImages" id="animalImages" value="{{ isset($animal) && $animal->exists ? json_encode(
        $animal->images->map(fn($img) => asset('storage/' .$img->path))) : '' }}">
        <input type="hidden" name="deletedImages" id="deletedImages" value="[]">
        {{-- ボタン --}}
        <div class="col-span-2 flex justify-center">
            <button type="submit" class="bg-green-700 text-white w-full md:w-auto px-6 py-3 rounded">
                {{ $buttonText }}
            </button>
        </div>
    </div>
</form>
{{-- 動物プロフィールモーダル --}}
<div id="animalCropModal" class="hidden fixed inset-0 z-[9999] bg-black/70 items-center justify-center">
    <div class="bg-white shadow-xl rounded-xl w-[95%] md:w-[900px] h-[90vh] md:h-[80vh] p-4 md:p-6 ">
        <div class="w-full h-[70vh] mx-auto overflow-hidden rounded bg-gray-100">
            <img id="animalCropTarget" class="w-full h-full object-contain">
        </div>
        <div class="flex justify-center items-center gap-5 mt-5">
            <button type="button" id="animalCropCancel" class="bg-gray-100 border px-4 py-2 rounded">
                キャンセル
            </button>
            <button type="button" id="animalCropSave" class="bg-green-700 text-white px-8 py-2 rounded">
                決定
            </button>
        </div>
    </div>
</div>
<div id="limitPopup"
     class="hidden fixed inset-0 items-center justify-center z-50">
    <div class="bg-black/70 text-white px-6 py-3 rounded-lg text-lg font-semibold
                opacity-0 transition-opacity duration-500">
        画像は最大5枚までです
    </div>
</div>