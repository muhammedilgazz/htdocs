@php
    $sortOptions = [
        'newest' => 'En Yeni',
        'popular' => 'En Popüler',
        'liked' => 'En Çok Beğenilen',
        'used' => 'En Çok Kullanılan'
    ];
    $currentSort = request('sort', 'newest');
@endphp

<div class="row gy-4 align-items-end mb-4">
    <div class="col-lg-6">
        <h3 class="text-white">{{ $title }}</h3>
        <p class="text-muted mb-0">{{ $count }} prompt bulundu</p>
    </div>
    <div class="col-lg-6 d-flex justify-content-lg-end align-items-center gap-3">
        <div class="downpdown_selector">
            <div class="dds_selected">
                <span>{{ $sortOptions[$currentSort] }}</span>
                <div class="dds_selected_icon"></div>
            </div>
            <div class="dds_select_lists">
                @foreach($sortOptions as $key => $label)
                    <div class="dds_select_item {{ $currentSort == $key ? 'active' : '' }}" data-sort="{{ $key }}">
                        <span>{{ $label }}</span>
                        <div class="dds_list_icon"></div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="btn-group" role="group">
            <button type="button"
                    class="btn btn-outline-secondary btn-sm {{ request('view') != 'list' ? 'active' : '' }}"
                    data-view="grid">
                <i class="bi bi-grid-3x3-gap"></i>
            </button>
            <button type="button"
                    class="btn btn-outline-secondary btn-sm {{ request('view') == 'list' ? 'active' : '' }}"
                    data-view="list">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>
</div>
