<div class="nft_grid_style__three bg-body section_gap_y_bottom__1">
    <div class="container">
        <div class="row gy-4 align-items-end">
            <div class="col-xl-2 col-lg-3 d-flex justify-content-between ">
                <div class="nft_grid__title">
                    <span class="sub-header-2">Özel Prompt'lar</span>
                    <h2 class="section_title__2">Yaratıcı Prompt'ları Keşfet</h2>
                </div>
            </div>

            <div class="col-xl-10 col-lg-9 d-flex justify-content-between flex-wrap gap-3">
                <ul class='nft_nav_pills__two nav nav-pills' id='pills-tab' role='tablist'>
                    <li class='nav-item' role='presentation'>
                        <button class='nav-link active' id='nft_pill_all' data-bs-toggle='pill' data-bs-target='#nft_tab_all' type='button' role='tab'>Tümü</button>
                    </li>
                    @foreach ($categories as $category)
                        <li class='nav-item' role='presentation'>
                            <button class='nav-link' id='nft_pill_{{ $category->id }}' data-bs-toggle='pill' data-bs-target='#nft_tab_{{ $category->id }}' type='button' role='tab'>
                                {{ $category->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="tab-content pt-50" id="pills-tabContent">
            <!-- Tüm Promtlar -->
            <div class="tab-pane fade show active" id="nft_tab_all" role="tabpanel">
                <div class="row row-cols-lg-4 row-cols-sm-2 row-cols-1 gy-4">
                    @foreach ($prompts as $prompt)
                        @include('components.prompt-card', ['prompt' => $prompt])
                    @endforeach
                </div>
            </div>

            <!-- Kategoriye Göre -->
            @foreach ($categories as $category)
                <div class="tab-pane fade" id="nft_tab_{{ $category->id }}" role="tabpanel">
                    <div class="row row-cols-lg-4 row-cols-sm-2 row-cols-1 gy-4">
                        @foreach ($category->prompts->take(8) as $prompt)
                            @include('components.prompt-card', ['prompt' => $prompt])
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
