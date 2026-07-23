<x-app-layout>
    <div class="flex">
        @include('org.sidebar')
        <div class="flex-1 p-10 max-w-4xl mx-auto">
            <section id="index" class="mb-8">
                @include('org.index')
            </section>
            <section id="animal.index">
                <h2 class="text-center text-2xl font-bold mb-6">保護動物一覧</h2>
                @include('org.animals.index')
            </section>
            <h2 class="text-center text-2xl font-bold my-6">保護団体詳細情報</h2>
            @include('org.profile')
        </div>
    </div>
    <div id="notification-overlay" class="fixed inset-0 bg-black/40 hidden"></div>

    <div id="notification-panel" class="fixed top-0 right-0 h-screen w-full md:w-[420px] bg-white shadow-2xl translate-x-full
        duration-300 ease-in-out rounded border-4 border-blue-500">
        <div class="flex items-center justify-evenly my-6">
            <h2 class="text-bold">通知一覧</h2>
            <div class="mr-6">
                <span>
                    🔔
                </span>
                @if($unreadCount > 0)
                    {{ $unreadCount }}
                @endif
            </div>
            <button id="close-notification-panel" class="text-2xl hover:text-red-500">
                ✕
            </button>
        </div>
        <div class="p-4 overflow-y-auto h-[calc(100vh-100px)]">
            @foreach($allNotifications as $notification)
                <a href="{{ route('notifications.show', $notification->id) }}" class="block border-t py-5 hover:bg-gray-100
                    {{ is_null($notification->read_at) ? 'bg-blue-50' : 'bg-white' }}">
                    <div class="flex items-center gap-2">
                        @if($notification->data['type'] === 'favorite')
                            <span class="text-red-400">❤</span>
                        @elseif($notification->data['type'] === 'match')
                            <span class="text-yellow-400">❤</span>
                        @elseif($notification->data['type'] === 'complete')
                            <span>🐶</span>
                        @endif
                        <p class="font-semibold">
                            {{ $notification->data['title'] }}
                        </p>
                    </div>
                    <p class="text-sm text-gray-600 mt-1 text-center">
                        {{ $notification->data['message'] }}
                    </p>
                    <p class="text-xs text-gray-400 mt-2">
                        {{ $notification->created_at->diffForHumans() }}
                    </p>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>