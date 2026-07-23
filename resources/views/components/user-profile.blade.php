<div class="bg-white w-[90vw] lg:w-[85vw] max-w-[900px] min-h-[650px] max-h-[90vh] overflow-y-auto p-4 lg:p-8 relative rounded-lg">
    <div class="flex">
        <h2 class="mb-4">ユーザー基本情報</h2>
        <button id="user-close-modal" class="absolute top-4 right-4 text-xl hover:text-red-500">x</button>
    </div>
    <div class="relative border-t lg:border-b border-black py-4">
        <div class="flex flex-col lg:flex-row items-start lg:items-center">
            {{-- 画像 --}}
            <div class="w-full lg:w-[55%] h-60 bg-gray-200 flex items-center justify-center lg:mr-6 overflow-hidden">
                <img id="modalUserImage" class="w-full h-full object-cover hidden">
                <div id="modalUserNoImage" class="w-full h-full flex items-center justify-center"></div>
            </div>
            {{-- 基本情報 --}}
            <div class="ml-0 lg:ml-6 mt-6 lg:mt-0 space-y-4 lg:space-y-10">
                <p>ニックネーム:<span data-field="nickname"></span></p>
                <p>居住エリア:<span data-field="residence_area"></span></p>
                <p>年齢:<span data-field="user_age"></span></p>
            </div>
        </div>
        <div class="hidden lg:block absolute top-0 bottom-0 left-[480px] border-l border-black"></div>
    </div>
    <div class="py-4 lg:py-14 space-y-6 lg:space-y-24 mb-10">
        <div class="block lg:flex lg:mb-10">
            <p class="w-full lg:w-40 mb-6 lg:mb-0">飼育経験:<span data-field="animal_care_experience"></span></p>
            <p class="w-full">飼育詳細情報:<span data-field="animal_care_details"></span></p>
        </div>
        <p>自己紹介:<span data-field="self_introduction"></span></p>
    </div>
</div>
