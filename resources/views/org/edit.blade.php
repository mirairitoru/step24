<x-app-layout>
    <div class="flex">
        @include('org.sidebar')
        <div class="flex-1 p-10">
            <h2 class="text-xl font-bold mb-6 text-center">団体情報編集画面</h2>
            <div class="max-w-4xl mx-auto bg-gradient-to-b from-blue-100 to-orange-100 p-6 border rounded-md shadow-md">
                <div class="bg-white border border-black px-6 py-6 rounded-md">
                    <form method="POST" action="{{ route('org.mypage.update') }}" enctype="multipart/form-data">
                        @csrf

                        <h3 class="font-bold">団体情報を編集</h3>
                        <div class="border-t border-black my-4">
                            <div class="flex items-center gap-7">
                                <div class="w-[60%] aspect-video bg-gray-200 my-4 flex items-center justify-center overflow-hidden rounded">
                                    <img id="preview" src="{{ $org->image ? asset('storage/'.$org->image->path) : '' }}" 
                                    class="w-full h-auto {{ $org->image ? '' : 'hidden' }}">
                                    <span id="placeholder" class="{{ $org->image ? 'hidden' : ''}}">
                                        画像なし
                                    </span>
                                </div>
                                <input type="file" name="image" id="imageInput" accept="image/*" class="hidden">
                                <button type="button" id="selectImage" class="border h-fit p-3 rounded bg-[#F56B01] text-white">
                                    画像を変更
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="cropped_image" id="croppedImage">
                        {{-- ここから下の編集する --}}
                        <div class="space-y-4">
                            {{-- 保護団体名 --}}
                            <div class="mb-4">
                                <div class="flex items-center">
                                    <label for="org_name" class="w-24 font-bold text-center">団体名：</label>
                                    <input type="text" name="org_name" id="org_name" value="{{ old('org_name', $org->org_name) }}" class="flex-1 rounded @error('org_name') border-red-500 @enderror">
                                </div>
                                @error('org_name')
                                    <div class="flex mt-1">
                                        <div class="w-20 mr-4"></div>
                                        <p class="text-red-500 text-sm">
                                            {{ $message }}
                                        </p>
                                    </div>
                                @enderror
                            </div>
                            {{-- 担当者 --}}
                            <div class="mb-4">
                                <div class="flex items-center">
                                    <label for="contact_name" class="w-24 font-bold text-center">担当者：</label>
                                    <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name', $org->contact_name) }}" class="flex-1 rounded @error('contact_name') border-red-500 @enderror">
                                </div>
                                @error('contact_name')
                                    <div class="flex mt-1">
                                        <div class="w-20 mr-4"></div>
                                        <p class="text-red-500 text-sm">
                                            {{ $message }}
                                        </p>
                                    </div>
                                @enderror
                            </div>
                            {{-- 所在地 --}}
                            <div class="mb-4">
                                <div class="flex items-center">
                                    <label for="location" class="w-24 font-bold text-center">所在地：</label>
                                    <input type="text" name="location" id="location" value="{{ old('location', $org->location) }}" class="flex-1 rounded @error('location') border-red-500 @enderror">
                                </div>
                                @error('location')
                                    <div class="flex mt-1">
                                        <div class="w-20 mr-4"></div>
                                        <p class="text-red-500 text-sm">
                                            {{ $message }}
                                        </p>
                                    </div>
                                @enderror
                            </div>
                            {{-- 活動内容 --}}
                            <div class="flex items-start">
                                <label for="activity_description" class="w-24 font-bold">活動内容：</label>
                                <textarea name="activity_description" id="activity_description" rows="3" class="flex-1 rounded border p-2">{{ old('activity_description', $org->activity_description) }}</textarea>
                            </div>
                            {{-- 譲渡実績 --}}
                            <div class="flex items-start">
                                <label for="adoption_summary" class="w-24 font-bold">譲渡実績：</label>
                                <textarea name="adoption_summary" id="adoption_summary" rows="3" class="flex-1 rounded border p-2">{{ old('adoption_summary', $org->adoption_summary) }}</textarea>
                            </div>
                            <div class="flex justify-center">
                                <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded">
                                    保存
                                </button>
                            </div>
                        </div>
                    </form>
                    {{-- トリミングモーダル --}}
                    <div id="cropModal" class="hidden fixed inset-0 z-50 bg-black/70 items-center justify-center">
                        <div class="bg-white rounded-xl p-6 shadow-xl">
                            <div class="w-full h-[70vh] mx-auto overflow-hidden rounded bg-gray-100">
                                <img id="cropTarget" class="w-full h-full object-contain">
                            </div>
                            <div class="flex justify-center gap-5 mt-5">
                                <button type="button" id="cropCancel" class="px-4 py-2 border">
                                    キャンセル
                                </button>
                                <button type="button" id="cropSave" class="px-4 py-2 bg-green-700 text-white">
                                    決定
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
