<div class="hero_style__three section_gap_y_bottom__1 position-relative">
    <img src="{{ asset('assets/images/shapes/hero-shape-three.png') }}" alt="Hero Şekli"
         class="d-lg-block d-none hero_bg__shape blend-overlay position-absolute top-0 end-0 z-neg-1">
    <img src="{{ asset('assets/images/shapes/hero-star.svg') }}" alt="Yıldız Şekli"
         class="hero_star__shape position-absolute start-0 top-50">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-7">
                <div class="hero__content">
                    <h1 class="text__outlined">AI PROMPT VİTRİNİ</h1>
                    <h1 class="text__gradient">YARATICI AI PROMPT'LARA HOŞ GELDİNİZ</h1>
                    <div class="hero__actions">
                        <a class="btn-rounded-v2" href="{{ route('collection.index') }}">Promptları Keşfet</a>
                        <a class="btn-rounded-v3 varient-2" href="{{ route('prompt.create') }}">Yeni Prompt Oluştur</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-lg-end">
                <div class="hero__featured">
                    <img src="{{ asset('assets/images/hero/hero-three-feat.jpg') }}" alt="Öne Çıkan Görsel">
                    <img src="{{ asset('assets/images/hero/hero-batch.png') }}" alt="Batch Görseli" class="hero__batch">
                </div>
            </div>
        </div>
    </div>
</div>