<div class="bg-gradient-to-b from-blue-50 to-orange-100 p-6 rounded-lg shadow-md">
    <div class="bg-white border border-black p-6 rounded-lg">
        <h2 class="font-bold">保護団体情報</h2>

        <div class="border-t border-black my-4">
            <div class="w-full h-60 bg-gray-200 my-4 flex rounded overflow-hidden">
                
                @if($org->image)
                    <img src="{{ asset('storage/'.$org->image->path) }}" class="w-full h-auto" alt="プロフィール画像">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        画像
                    </div>
                @endif
            </div>
        </div>
        <div class="space-y-4">
            <div class="flex items-center">
                <span class="w-24 text-center">団体名：</span>
                <p class="flex-1 border px-3 py-1 border-black min-h-[34px]">{{ $org->org_name }}</p>
            </div>
            <div class="flex items-center">
                <span class="w-24 text-center">担当者：</span>
                <p class="flex-1 border px-3 py-1 border-black min-h-[34px]">{{ $org->contact_name }}</p>
            </div>
            <div class="flex items-center">
                <span class="w-24 text-center">所在地：</span>
                <p class="flex-1 border px-3 py-1 border-black min-h-[34px]">{{ $org->location }}</p>
            </div>
            <div class="flex items-start">
                <span class="w-24">活動内容：</span>
                <p class="flex-1 border px-3 py-1 border-black min-h-[60px]">{{ $org->activity_description }}</p>
            </div>
            <div class="flex items-start">
                <span class="w-24">譲渡実績：</span>
                 <p class="flex-1 border px-3 py-1 border-black min-h-[60px]">{{ $org->adoption_summary }}</p>
            </div>
        </div>
    </div>
</div>