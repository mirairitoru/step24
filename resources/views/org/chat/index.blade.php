<x-app-layout>
    <div class="flex">
        @include('org.sidebar')
        <div class="flex-1 px-10 py-20">
            <h2 class="text-center text-xl font-bold mb-6">チャット一覧</h2>
            <div class="border bg-gradient-to-r from-blue-100 to-orange-100 rounded-lg shadow-md mt-6 p-6 max-w-4xl mx-auto">
                <div class="bg-white border border-black p-3 lg:p-6 flex flex-col lg:flex-row min-h-[700px]">
                    <div class="hidden lg:flex w-full">
                        @include('org.chat.chat-list')
                        @include('org.chat.show')
                    </div>
                    <div class="lg:hidden">
                        @if(request()->routeIs('org.chat.index'))
                            @include('org.chat.chat-list')
                        @else
                            @include('org.chat.show')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>