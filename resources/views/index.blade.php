<x-app-layout>
    <div class="px-6 relative">
        <img src="/images/dog-cat_image.png" class="w-full h-auto object-cover" alt="dog-cat画像">
        <div class="absolute left-20 top-1/2 -translate-y-1/2">
            <p class="text-xs md:text-2xl font-bold leading-[2.8]">
                新たな出会いが見つかるきっかけ<br>
                あなたの行動した<span class="text-[#F56B01]">勇気</span>が未来を変える
            </p>
        </div>
    </div>
    <h2 class="font-bold flex text-lg justify-center my-20">新しい家族、かけがえのないパートナーを見つけよう</h2>
    <div class="flex items-center justify-center my-6 gap-4">
        <svg class="icon icon-paw w-12 h-12 text-[#F56B01] px-1">
            <use href="/icons.svg#icon-paw"></use>
        </svg>
        <h2 class="font-bold text-4xl my-6 text-[#5293FF]">動物検索</h2>
        <svg class="icon icon-paw w-12 h-12 text-[#F56B01] px-1">
            <use href="/icons.svg#icon-paw"></use>
        </svg>
    </div>
    <div class="my-10 py-6">
        @include('components.search')
    </div>
    <div class="flex items-center justify-center my-6 gap-4">
        <svg class="icon icon-paw w-12 h-12 text-[#5293FF] px-1">
            <use href="/icons.svg#icon-paw"></use>
        </svg>
        <h2 class="font-bold text-4xl my-6 text-[#F56B01]">動物一覧</h2>
        <svg class="icon icon-paw w-12 h-12 text-[#5293FF] px-1">
            <use href="/icons.svg#icon-paw"></use>
        </svg>
    </div>

    @include('org.animals.show') 
</x-app-layout>