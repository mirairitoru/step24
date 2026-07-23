<button
    type="button"
    class="open-user-modal border px-3 py-1 rounded bg-blue-500 text-white"

    data-nickname="{{ $match->user->nickname }}"
    data-residence_area="{{ $match->user->residence_area }}"
    data-user_age="{{ $match->user->user_age }}"
    data-animal_care_experience="{{ $match->user->animal_care_experience }}"
    data-animal_care_details="{{ $match->user->animal_care_details }}"
    data-self_introduction="{{ $match->user->self_introduction }}"
    data-image="{{ $match->user->image ? asset('storage/' .$match->user->image->path) : ''}}"
>
    ユーザー詳細
</button>