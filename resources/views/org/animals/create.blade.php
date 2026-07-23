<x-app-layout>
    <div class="flex">
        @include('org.sidebar')
        <div class="flex-1 p-10 max-w-4xl mx-auto">
            <h2 class="text-xl font-bold mb-6 text-center text-[#5293FF]">保護<span class="text-[#F56B01]">動物</span>登録画面</h2>
            <div class="max-w-3xl mx-auto p-6 border rounded-md shadow-md">
                <x-animal-form
                    :action="route('org.animals.store')"
                    method="POST"
                    buttonText="登録"
                />
            </div>
        </div>
    </div>
</x-app-layout>
