<x-app-layout>
    <div class="flex">
        
        {{-- サイドバー --}}
        @include('user.sidebar')

        {{-- メイン --}}
        <div class="flex-1 p-10 h-full">
            <h2 class="text-xl font-bold mb-10 text-center text-[#5293FF]">プロフィール編集画面</h2>

            <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg">

                <form method="POST" action="{{ route('mypage.update') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- ニックネーム --}}
                    <div class="mb-6">
                        <div class="flex items-center">
                            <label for="nickname" class="w-32">ニックネーム:</label>
                            <input type="text" name="nickname" id="nickname"
                                value="{{ old('nickname', $user->nickname) }}"
                                class="flex-1 border rounded p-2 @error('nickname') border-red-500 @enderror">
                        </div>
                        @error('nickname')
                            <p class="text-red-500 text-sm ml-32">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 居住エリア --}}
                    <div class="mb-6 flex items-center">
                        <label for="residence_area" class="w-32">居住エリア:</label>
                        <input type="text" name="residence_area" id="residence_area"
                            value="{{ old('residence_area', $user->residence_area) }}"
                            class="flex-1 border rounded p-2">
                    </div>

                    {{-- 年齢 --}}
                    <div class="mb-6">
                        <div class="flex items-center">
                            <label for="user_age" class="w-32">年齢:</label>
                            <input type="text" name="user_age" id="user_age"
                                value="{{ old('user_age', $user->user_age) }}"
                                class="border text-center w-24 rounded p-2 @error('user_age') border-red-500 @enderror">
                        </div>
                        @error('user_age')
                            <p class="text-red-500 text-sm ml-32">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- 飼育経験 --}}
                    <div class="mb-6 flex items-center">
                        <label for="animal_care_experience" class="w-32">飼育経験:</label>
                        <select name="animal_care_experience"
                            class="border p-2 w-60 rounded text-center">
                            <option value="">選択してください</option>
                            <option value="あり" {{ old('animal_care_experience', $user->animal_care_experience) === 'あり' ? 'selected' : '' }}>あり</option>
                            <option value="なし" {{ old('animal_care_experience', $user->animal_care_experience) === 'なし' ? 'selected' : '' }}>なし</option>
                        </select>
                    </div>

                    {{-- 飼育詳細 --}}
                    <div class="mb-6 flex items-center">
                        <label for="animal_care_details" class="w-32">飼育詳細情報:</label>
                        <input type="text" name="animal_care_details" id="animal_care_details"
                            value="{{ old('animal_care_details', $user->animal_care_details) }}"
                            class="flex-1 border rounded p-2">
                    </div>

                    {{-- 自己紹介 --}}
                    <div class="mb-6 flex">
                        <label for="self_introduction" class="w-32">自己紹介:</label>
                        <textarea name="self_introduction" id="self_introduction" rows="4"
                            class="flex-1 border rounded p-2">{{ old('self_introduction', $user->self_introduction) }}</textarea>
                    </div>

                    {{-- プロフィール画像 --}}
                    @php
                        $profileImage = $user?->image;
                    @endphp
                    <div class="mb-6 flex items-start">
                        <label class="w-32 pt-2">トップ画像:</label>

                        <div class="flex flex-col gap-3 flex-1">
                            <label for="userImageInput" class="w-full max-w-xl h-40 overflow-hidden rounded border bg-white cursor-pointer
                            hover:bg-gray-50 flex items-center justify-center relative">

                                {{-- プレビュー表示 --}}
                                <div id="userPlaceholder" class="w-full h-full flex items-center justify-center border-[#5293FF] border-2 border-dashed">
                                    <span class="text-blue-500 text-center">
                                        画像アップロード
                                    </span> 
                                </div>
                                <input type="file" id="userImageInput" accept="image/*" class="hidden">
                            </label>
                            <input type="hidden" name="cropped_image" id="userImage">
                            <input type="hidden" id="existingUserImage" value="{{ $profileImage ? asset('storage/' .$profileImage->path) : '' }}">
                            <input type="hidden" name="deleteUserImage" id="deleteUserImage" value="0">
                        </div>
                    </div>

                    {{-- ボタン --}}
                    <div class="flex justify-center mt-8">
                        <button type="submit" class="bg-green-700 text-white px-8 py-2 rounded-lg shadow">
                            更新する
                        </button>
                    </div>
                </form>
                {{-- ユーザープロフィールモーダル --}}
                <div id="userCropModal" class="hidden fixed inset-0 z-[9999] bg-black/70 items-center justify-center">
                    <div class="bg-white p-6 shadow-xl rounded-xl w-[900px] h-[80vh]">
                        <div class="w-full h-[70vh] mx-auto overflow-hidden rounded bg-gray-100">
                            <img id="userCropTarget" class="w-full h-full object-contain">
                        </div>
                        <div class="flex justify-center items-center gap-5 mt-5">
                            <button type="button" id="userCropCancel" class="bg-gray-100 border px-4 py-2 rounded">
                                キャンセル
                            </button>
                            <button type="button" id="userCropSave" class="bg-green-700 text-white px-8 py-2 rounded">
                                決定
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
