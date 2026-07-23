<div id="modal" class="fixed inset-0 z-50 bg-black/50 hidden justify-center items-center p-8">
    <div class="bg-white p-4 lg:p-8 w-[90vw] lg:w-[85vw] max-w-[900px] max-h-[90vh] overflow-y-auto rounded-lg relative">
        <div class="flex border-b pb-3">
            <h2 class="mb-2 text-lg md:text-2xl font-bold">里親募集中一覧 > <span id="modal-title"></span></h2>
            <button id="close-modal" class="absolute top-4 right-10 text-2xl hover:text-red-500">✕</button>
        </div>
        <div class="flex flex-col lg:flex-row mt-6 gap-6">
            <div class="group relative flex items-center justify-center bg-gray-200 w-full lg:w-[65%] h-[280px] rounded-md overflow-hidden">
                <div id="modal-carousel" class="w-full h-full"></div>
                <button id="modal-prev" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/70 text-white px-3 py-2 rounded-full invisible group-hover:visible">
                    <
                </button>
                <button id="modal-next" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/70 text-white px-3 py-2 rounded-full invisible group-hover:visible">
                    >
                </button>
            </div>
            <div class="block ml-2 md:ml-6 space-y-4 text-lg">
                <p>名前：<span data-field="animal_name"></span></p>
                <p>種類：<span data-field="species"></span></p>
                <p>年齢：<span data-field="age"></span></p>
                <p>性別：<span data-field="sex"></span></p>
                <p>ステータス：<span data-field="adoption_status"></span></p>
                <form id="favorite-form" method="POST">
                    @csrf
                    <button id="modal-favorite-btn" class="border text-white px-3 py-2 lg:py-3 w-full rounded">
                        興味あり
                    </button>
                </form>
            </div>
        </div>
        <div class="mt-8 space-y-10 text-lg">
            <p class="flex items-start">
                <span class="pt-1 w-[160px] shrink-0">
                    性格：
                </span>
                <span data-field="personality" class="text-center grid grid-cols-2 lg:grid-cols-4 gap-2 rounded"></span>
            </p>
            <p class="flex flex-wrap items-start">
                <span class="w-[160px] shrink-0">
                    健康状態：
                </span>
                <span data-field="health_status"></span>
            </p>
            <p class="flex items-start">
                <span class="w-[160px] shrink-0">
                    所属保護団体：
                </span>
                <span data-field="org_name"></span>
            </p>
            <p class="flex items-start">
                <span class="w-[160px] shrink-0">
                    コメント：
                </span>
                <span data-field="comment" class="border border-black min-h-[150px] w-full rounded p-4"></span>
            </p>
        </div>
    </div>
</div>