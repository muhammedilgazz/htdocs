@php
    $promptUrl = route('prompt.show', $prompt->id);
    $imageSrc = $prompt->picture ? asset($prompt->picture) : asset('assets/images/default-prompt.png');
@endphp
<div class="col" data-category="{{ $prompt->main_cat_id }}">
    <div class="nft_card_style__two">
        <div class="nft__thumb">
            <div class="nft__cover">
                <a href="{{ $promptUrl }}">
                    <img src="{{ $imageSrc }}" alt="{{ $prompt->title }}" loading="lazy">
                </a>
            </div>

            <div class="nft__actions">
                <div class="avater__group bttm-zero">
                    <img src=" {{ asset('assets/images/sellers/mvi-small.png') }}" alt="Avater">
                    <img src=" {{ asset('assets/images/icons/tick-yellow-x.svg') }}" alt="Verified" class="user__tick">
                </div>
                @if($prompt->category)
                    <h6 class="artist__name prompt-cat"><a
                            href="{{ route('collection.index', ['category' => $prompt->main_cat_id]) }}">{{ $prompt->category->description }}</a>
                    </h6>
                @endif
                <button class="actions__btn fav__btn" data-prompt-id="{{ $prompt->id }}">
                    <img src="{{ asset('assets/images/icons/red-heart.svg') }}" alt="Favorite">
                </button>
                <button class="actions__btn info__btn bttm-zero" data-prompt-id="{{ $prompt->id }}">
                    <i class="bi bi-three-dots"></i>
                </button>
            </div>

        </div>
        <div class="nft__disc">
            <h5 class="nft__title">
                <a href="{{ $promptUrl }}">{{ $prompt->title }}</a>
            </h5>
            <div class="nft__info">
                @if($prompt->prompt_agent)
                <ins>
                    <img src="{{ asset('assets/images/icons/tri-flash-pink.svg') }}" alt="AI Model">
                    {{ $prompt->prompt_agent }}
                </ins>
                @endif
                <span>{{ $prompt->used_times ?? 0 }} kez kullanıldı</span>
            </div>
            <div class="nft__btns">
                <a href="{{ $promptUrl }}" class="collection_btn count__down"> Prompt'u Görüntüle</a>
                <a href="{{ $promptUrl }}" class="bid-btn">Kullan</a>
            </div>
        </div>
    </div>
</div>
