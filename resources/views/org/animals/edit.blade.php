<x-app-layout>
    <div class="flex">
        @include('org.sidebar')
        <div class="flex-1 p-10">
            <h2 class="text-xl font-bold mb-6 text-center">保護動物編集画面</h2>
            <div class="max-w-3xl mx-auto rounded-md shadow-md p-6 border">
                <x-animal-form
                    :action="route('org.animals.update', $animal->id)"
                    method="PUT"
                    :animal="$animal"
                    buttonText="更新"
                />
            </div>
        </div>
    </div>
</x-app-layout>