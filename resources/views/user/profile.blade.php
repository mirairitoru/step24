<div class="bg-gradient-to-r from-orange-100 to-blue-100 p-6 min-h-[675px] rounded-lg shadow-lg">
    <div class="bg-white border border-black p-6 rounded-lg min-h-[627px]">
        <h2 class="mb-4">ユーザー基本情報</h2>

        <div class="relative border-t lg:border-b border-black py-6">
            <div class="flex flex-col lg:flex-row items-start lg:items-center">
                {{-- 画像 --}}
                <div class="w-full lg:w-[55%] h-60 bg-gray-200 flex items-center justify-center lg:mr-6 overflow-hidden">
                    @if($user->image)
                        <img src="{{ asset('storage/' . $user->image->path) }}" class="w-full h-full" alt="プロフィール画像">                
                    @else
                        <span class="text-xl">
                            画像
                        </span>
                    @endif
                </div>
                {{-- 基本情報 --}}
                <div class="ml-0 lg:ml-6 space-y-4 lg:space-y-10 mt-6 lg:mt-0">
                    <p>ニックネーム:<span>{{ $user->nickname }}</span></p>
                    <p>居住エリア:<span>{{ $user->residence_area }}</span></p>
                    <p>年齢:<span>{{ $user->user_age }}</span></p>
                </div>
            </div>
            <div class="hidden lg:block absolute top-0 bottom-0 left-[430px] border-l border-black"></div>
        </div>
        <div class="md:py-8 space-y-4 md:space-y-20 mb-20">
            <div class="block md:flex md:mb-10">
                <p class="w-full md:w-40 mb-4 md:mb-0">飼育経験:<span>{{ $user->animal_care_experience }}</span></p>
                <p class="w-full">飼育詳細情報:<span>{{ $user->animal_care_details }}</span></p>
            </div>
            <p>自己紹介:<span>{{ $user->self_introduction }}</span></p>
        </div>
    </div>
</div>