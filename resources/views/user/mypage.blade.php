<x-app-layout>
    <div class="grid grid-cols-1 md:grid-cols-[240px_1fr] gap-6 md:gap-20 px-4 md:px-6 pb-4">
        @include('user.sidebar')
        <div class="flex-1 p-4 md:p-10 max-w-full md:max-w-4xl">
            <h2 class="text-center text-xl font-bold my-6">プロフィール基本情報</h2>
            @include('user.profile')
            <section id="index">
                <h2 class="text-center text-xl font-bold my-6">興味ありリスト一覧</h2>
                @include('user.index')
            </section>
            <section id="match">
                <h2 class="text-center text-xl font-bold my-6">マッチした動物一覧</h2>
                @include('user.match')
            </section>
        </div>
    </div>
</x-app-layout>