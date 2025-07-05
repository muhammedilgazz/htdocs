<div class='col'>
    <div class='nft_card_style__two'>
        <div class='nft__thumb'>
            <div class='nft__cover'>
                <a href='/nft-detail?id={{ $prompt->id }}'>
                    <img src='{{ asset($prompt->picture) }}' alt='{{ $prompt->title }}'>
                </a>
            </div>
            <div class='nft__actions'>
                <button class='actions__btn fav__btn' onclick='toggleFavorite({{ $prompt->id }})'>
                    <img src='{{ asset("assets/images/icons/red-heart.svg") }}' alt='Favorite'>
                </button>
                <button class='actions__btn info__btn' onclick='showPromptInfo({{ $prompt->id }})'>
                    <i class='bi bi-three-dots'></i>
                </button>
                <div class='avater__group'>
                    <img src="{{ asset("assets/images/nft/ag-two.png") }}" alt="">
                    <img src="{{ asset("assets/images/nft/ag-three.png") }}" alt="">

                    <img src='{{ asset("assets/images/icons/tick-yellow-x.svg") }}' alt='Verified' class='user__tick'>
                </div>
            </div>
        </div>
        <div class='nft__disc'>
            <h5 class='nft__title'>
                <a href='/nft-detail?id={{ $prompt->id }}'>{{ $prompt->title }}</a>
            </h5>
            <div class='nft__info'>
                <ins>
                    <img src='{{ asset("assets/images/icons/tri-flash-pink.svg") }}' alt='AI Model'>
                    {{ $prompt->prompt_agent }}
                </ins>
                <span>{{ $prompt->used_times }} kez kullanıldı</span>
            </div>
            <div class='nft__btns'>
                <div class='count__down countdown'>
                    <a href='/nft-detail?id={{ $prompt->id }}' class='collection_btn'>Prompt'u Görüntüle</a>
                </div>
                <a class='bid-btn' href='/nft-detail?id={{ $prompt->id }}'>Kullan</a>
            </div>
        </div>
    </div>
</div>
