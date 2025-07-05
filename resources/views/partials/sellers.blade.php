<div class="seller_style__three bg-body section_gap_y_bottom__1">
    <div class="container">
        @include('components.centered-header', [
            'title' => 'En Çok Beğenilenler',
            'description' => 'En popüler AI prompt pazar yeri'
        ])

        <div class="row gy-xl-0 gy-3">
            @forelse($latestSellers as $seller)
                <div class="col-lg-3 col-md-6 col-sm-6">
                    @include('partials.seller-card', ['seller' => $seller])
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Henüz satıcı bulunamadı</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
