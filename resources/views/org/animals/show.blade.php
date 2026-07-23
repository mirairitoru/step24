@if($animals->isEmpty())
    <p class="flex flex-col items-center justify-center text-xl">
        <span class="whitespace-nowrap">
            まだ新しいパートナーが登録されていません
        </span>
        <span class="whitespace-nowrap">
            これからあなたは未来のペットと出会うきっかけの第1歩になるかもしれません
        </span>
        <span class="whitespace-nowrap">
            素敵な家族との出会いが待っているかもしれませんね❤
        </span>
    </p>
@else
    <div class="grid grid-cols-2 md:grid-cols-3 mx-auto gap-8">
        @foreach ($animals as $animal)
            @if($animal->adoption_status === '募集中')
                <div class="border border-black p-4 text-center shadow-lg rounded-lg">
                    @if($animal->topImage())
                        <img src="{{ asset('storage/' .$animal->topImage()->path) }}" alt="イメージ" class="w-full h-40 object-cover rounded">
                    @else
                        <div class="bg-gray-200 h-40 flex items-center justify-center">
                            画像なし
                        </div>
                    @endif
                    <div class="mt-4 space-y-2">
                        <p class="grid grid-cols-3">
                            <span class="text-left">名前:</span>
                            <span class="text-center">
                                {{ $animal->animal_name }}
                            </span>
                        </p>
                        <p class="grid grid-cols-3">
                            <span class="text-left">種類:</span>
                            <span class="text-center">
                                {{ $animal->species }}
                            </span>
                        </p>
                        <p class="grid grid-cols-3">
                            <span class="text-left">年齢:</span>
                            <span class="text-center whitespace-nowrap">
                                {{ $animal->age_label }}{{ $animal->age_sub }}
                            </span>
                        </p>
                        <p class="grid grid-cols-3">
                            <span class="text-left">性別:</span>
                            <span class="text-center">
                                {{ $animal->sex }}
                            </span>
                        </p>
                        <div class="grid grid-cols-3 mt-2">
                            <span class="text-left shrink-0">性格:</span>

                            @php
                                $personalities = collect($animal->personality)
                                    ->flatten()
                                    ->take(1);   
                            @endphp
                            <div class="flex-1 flex justify-center gap-2">
                                @foreach ($personalities as $personality)
                                    <span class="border text-center border-black px-2 py-1 rounded-md">
                                        {{ is_array($personality) ? implode(',', $personality) : $personality }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        <div class="text-center justify-center py-2">
                            @include('components.modal-button')
                        </div>
                    </div>
                </div>
            @endif   
        @endforeach
    </div>
@endif

<div class="mt-6 mb-8 text-center flex justify-center">
    {{ $animals->links() }}
</div>
@include('components.modal')