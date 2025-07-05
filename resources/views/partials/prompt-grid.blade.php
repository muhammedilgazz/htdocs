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
                <div class="select_style__one varient-4">
                    <div class="downpdown_selector">
                        <div class="dds_selected selector_three"><span>Popüler Prompt'lar</span>
                            <div class="dds_selected_icon"></div>
                        </div>
                        <div class="dds_select_lists " style="height:0">
                            <div class="dds_select_item"><span>Favori Prompt'larım</span>
                                <div class="dds_list_icon"></div>
                            </div>
                            <div class="dds_select_item"><span>Popüler Prompt'lar</span>
                                <div class="dds_list_icon"></div>
                            </div>
                            <div class="dds_select_item"><span>Yeni Prompt'lar</span>
                                <div class="dds_list_icon"></div>
                            </div>
                            <div class="dds_select_item"><span>Tümü</span>
                                <div class="dds_list_icon"></div>
                            </div>
                            <div class="dds_select_item"><span>Klasik Prompt'lar</span>
                                <div class="dds_list_icon"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class='nft_nav_pills__two nav nav-pills' id='pills-tab' role='tablist'>
                    <li class='nav-item' role='presentation'>
                        <button class='nav-link active' id='nft_pill_all' data-bs-toggle='pill' data-bs-target='#nft_tab_all' type='button' role='tab'>Tümü</button>
                    </li>
                    @foreach ($categories as $category)
                        <li class='nav-item' role='presentation'>
                            <button class='nav-link' id='nft_pill_{{ $category->id }}' data-bs-toggle='pill' data-bs-target='#nft_tab_{{ $category->id }}' type='button' role='tab'>
                                {{ $category->description }}
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
        <div class="more-load-wrap text-center mt-50">
            <a class="load-more-btn varient-2" href="collection">
                <svg width="18" height="19" fill="none" viewBox="0 0 18 19" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M11.775 3.61794C11.0224 3.39694 10.192 3.25244 9.27502 3.25244C5.13143 3.25244 1.77502 6.55046 1.77502 10.622C1.77502 14.702 5.13143 18 9.27502 18C13.4186 18 16.775 14.702 16.775 10.6305C16.775 9.11747 16.3079 7.70646 15.512 6.53346"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M12.848 3.82201L10.348 1" stroke-width="1.8" stroke-linecap="round"
                          stroke-linejoin="round"></path>
                    <path d="M12.8478 3.82202L9.93256 5.91303" stroke-width="1.8" stroke-linecap="round"
                          stroke-linejoin="round"></path>
                </svg>
                Tümünü Gör
            </a>
        </div>

    </div>
</div>
