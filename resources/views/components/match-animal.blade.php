<button
    class="open-modal border bg-gray-200 px-3 py-1 w-full"

    data-animal_name="{{ $match->animal->animal_name }}"
    data-species="{{ $match->animal->species }}"
    data-age="{{ $match->animal->age_label }}{{ $match->animal->age_sub }}"
    data-sex="{{ $match->animal->sex }}"
    data-adoption_status="{{ $match->animal->adoption_status }}"
    data-personality="{{ implode(',', $match->animal->personality ?? []) }}"
    data-health_status="{{ $match->animal->health_status }}"
    data-org_name="{{ $match->animal->organization->org_name }}"
    data-comment="{{ $match->animal->comment }}"
    data-role="{{ Auth::guard('web')->check() ? 'user' : (Auth::guard('org')->check() ? 'organization' : 'guest')}}"
    data-favorited="{{ $match->animal->isFavorited ? 'true' : 'false' }}"
    data-images="{{ json_encode($match->animal->images->map(fn($img) => asset('storage/' .$img->path))) }}"
>
    詳細情報
</button>