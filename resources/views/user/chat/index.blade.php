<x-app-layout>
    <div class="flex">
        @include('user.sidebar')
        <div class="flex-1 px-10 py-20">
            <h2 class="text-center text-xl font-bold mb-6">チャット一覧</h2>
            <div class="border bg-gradient-to-r from-orange-100 to-blue-100 rounded-lg shadow-md mt-6 p-6 max-w-4xl mx-auto">
                <div class="bg-white border border-black p-3 lg:p-6 flex flex-col lg:flex-row min-h-[700px]">
                    <div class="hidden lg:flex w-full">
                        @include('user.chat.chat-list')
                        @include('user.chat.show')
                    </div>
                    <div class="lg:hidden">
                        @if(request()->routeIs('user.chat.index'))
                            @include('user.chat.chat-list')
                        @else
                            @include('user.chat.show')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>