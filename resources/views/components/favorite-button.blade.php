{{-- 詳細 --}}
<button class="bg-gray-200 px-4 py-1 w-28 open-modal"
    data-id="{{ $animal->id }}"
    data-animal_name="{{ $animal->animal_name }}"
    data-species="{{ $animal->species }}"
    data-age="{{ $animal->age_label }}{{ $animal->age_sub }}"
    data-sex="{{ $animal->sex }}"
    data-adoption_status="{{ $animal->adoption_status }}"
    data-personality="{{ implode(',', $animal->personality ?? []) }}"
    data-health_status="{{ $animal->health_status }}"
    data-org_name="{{ $animal->organization->org_name }}"
    data-comment="{{ $animal->comment }}"
    data-role="{{ Auth::guard('web')->check() ? 'user' : (Auth::guard('organization')->check() ? 'organization' : 'guest')}}"
    data-favorited="{{ $animal->isFavorited ? 'true' : 'false' }}"
    data-images="{{ json_encode($animal->images->map(fn($img) => asset('storage/' .$img->path))) }}"
>
    詳細情報
</button>