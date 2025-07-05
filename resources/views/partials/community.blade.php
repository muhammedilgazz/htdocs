<div class="community_style_one section_gap_y_bottom__1 section_gap_y_top__1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h2 class="section_title__2">Topluluğa Katılın</h2>
                <p class="disc-text pt-2">Prompt Dünyası topluluğuna katılın, diğer kullanıcılarla iletişime geçin ve
                    fikirlerinizi paylaşın.</p>
                <ul class="community_social__links d-flex flex-wrap justify-content-center">
                    <li><a href="/"><i class="bi bi-twitter"></i></a></li>
                    <li><a href="/"><i class="bi bi-linkedin"></i></a></li>
                    <li><a href="/"><i class="bi bi-youtube"></i></a></li>
                    <li><a href="/"><i class="bi bi-github"></i></a></li>
                    <li><a href="/"><i class="bi bi-discord"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="row section_gap_y_top__1 nft_process__wrap justify-content-center gy-4">
            @php
                $processes = [
                    ['icon' => 'process-doc.svg', 'title' => 'Koleksiyon Oluşturun', 'desc' => 'Yaratıcı AI prompt\'larınızı düzenleyin ve kategorilere ayırın.'],
                    ['icon' => 'process-card.svg', 'title' => 'Hesabınızı Oluşturun', 'desc' => 'Size özel bir yazar profili oluşturun ve başlayın.'],
                    ['icon' => 'process-sell.svg', 'title' => 'Prompt\'larınızı Paylaşın', 'desc' => 'Diğer kullanıcılarla paylaşın ve gelir elde edin.'],
                    ['icon' => 'process-add.svg', 'title' => 'Yeni Prompt Oluşturun', 'desc' => 'Kendi AI prompt\'larınızı oluşturun ve paylaşın.']
                ]
            @endphp
            @foreach($processes as $process)
                <div class="col-lg-3 col-sm-6">
                    <div class="nft_process__card">
                        <div class="process__icon">
                            <img src="{{ asset('assets/images/icons/' . $process['icon']) }}"
                                 alt="{{ $process['title'] }}">
                        </div>
                        <h5>{{ $process['title'] }}</h5>
                        <p>{{ $process['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
