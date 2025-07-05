@php
    $selectedCategory = request('category');
@endphp

<div class="accordion-item sidebar_collections__filter sidebar__filter">
    <h2 class="accordion-header sidebar__header" id="filterHeadingFour">
        <ins class="col__name my-button">
            Kategoriler
        </ins>
    </h2>

    <div id="filter-collapse" class="according_collapse show">
        <div class="accordion-body sidebar__body">
            <ul>
                {{-- Tüm Kategoriler --}}
                <li class="single__col">
                    <label>
                        <a href="{{ request()->url() }}"
                           class="col__right {{ !$selectedCategory ? 'active' : '' }}">
                            <span class="cate_icon">
                                {{-- Varsayılan SVG ikonu (Tüm) --}}
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.2"/>
                                </svg>
                            </span>
                            <ins class="col__name">Tüm Kategoriler</ins>
                        </a>

                    </label>
                </li>

                {{-- Tekil Kategoriler --}}
                @forelse($categories as $category)
                    <li class="single__col">
                        <label>
                            <a href="?category={{ $category->id }}"
                               class="col__right {{ $selectedCategory == $category->id ? 'active' : '' }}">
                                <span class="cate_icon">
                                    {{-- Opsiyonel kategoriye göre farklı SVG ikonu --}}
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                        <path d="M8 1C4.134 1 1 4.134 1 8s3.134 7 7 7 7-3.134 7-7-3.134-7-7-7z"
                                              stroke="currentColor" stroke-width="1.2"/>
                                    </svg>
                                </span>
                                <ins class="col__name">{{ $category->description ?? $category->name }}</ins>
                            </a>
                            <span class="badge bg-secondary float-end">{{ $category->prompts->count() }}</span>

                        </label>
                    </li>
                @empty
                    <li class="single__col text-muted text-center">
                        <label>Kategori bulunamadı</label>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
