<x-app-layout>
    <div class="flex">
        @include('org.sidebar')
        <div class="flex-1 px-10 py-20">
            <h2 class="text-center text-xl font-bold mb-6">マッチ管理</h2>
            <div class="border bg-gradient-to-r from-blue-100 to-orange-100 rounded-lg shadow-md mt-6 p-6 max-w-4xl mx-auto">
                <div class="bg-white border border-black p-4 lg:p-6 flex flex-col gap-4 lg:flex-row min-h-[700px] rounded">
                    @include('org.partials.match-animal-list')
                    <div class="w-full lg:w-2/3 px-4 min-h-0">
                        @include('org.partials.match-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
