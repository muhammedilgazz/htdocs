@php
    $menuItems = [
        ['title' => 'Anasayfa', 'url' => '/'],
        [
            'title' => 'Keşfet',
            'submenu' => [
                ['title' => 'Görsel Prompt\'lar', 'url' => '/gorsel-promptlar'],
                ['title' => 'Görev Prompt\'ları', 'url' => '/gorev-promptlar'],
                ['title' => 'Agent Bazlı Prompt\'lar', 'url' => '/agent-promptlar']
            ]
        ],
        [
            'title' => 'Sayfalar',
            'submenu' => [
                ['title' => 'Hakkımızda', 'url' => '/about'],
                ['title' => 'Popüler Prompt\'lar', 'url' => '/live-auction'],
                ['title' => 'Prompt Koleksiyonları', 'url' => '/collection'],
                ['title' => 'Faaliyetler', 'url' => '/activity'],
                ['title' => 'Hesabınıza Giriş Yapın', 'url' => '/connect-wallet'],
                ['title' => 'Prompt Detayları', 'url' => '/nft-details'],
                ['title' => 'Yazar Profili', 'url' => '/author-profile'],
                ['title' => 'Giriş Yap', 'url' => '/login'],
                ['title' => 'Kayıt Ol', 'url' => '/register']
            ]
        ],
        [
            'title' => 'Oluştur',
            'submenu' => [
                ['title' => 'Yeni Prompt Oluştur', 'url' => '/create-prompt'],
                ['title' => 'Prompt Koleksiyonu Oluştur', 'url' => '/create-collection'],
                ['title' => 'AI Agent Oluştur', 'url' => '/create-agent'],
                ['title' => 'Yazar Profili', 'url' => '/creators']
            ]
        ],
        [
            'title' => 'Blog',
            'submenu' => [
                ['title' => 'Blog Yazıları Grid', 'url' => '/blog'],
                ['title' => 'Blog Yazıları Detayları', 'url' => '/blog-details']
            ]
        ],
        ['title' => 'İletişim', 'url' => '/contact']
    ];
@endphp

<nav class="main-nav mr-2">
    <ul>
        @foreach($menuItems as $item)
            @if(isset($item['submenu']))
                <li class="has-child-menu">
                    <a>{{ $item['title'] }}</a>
                    <i class="fl flaticon-plus">+</i>
                    <ul class="sub-menu sub_menu_show" data-height="{{ count($item['submenu']) * 40 }}px">
                        @foreach($item['submenu'] as $subItem)
                            <li><a href="{{ $subItem['url'] ?? '#' }}">{{ $subItem['title'] }}</a></li>
                        @endforeach
                    </ul>
                </li>
            @else
                <li><a href="{{ $item['url'] ?? '#' }}">{{ $item['title'] }}</a></li>
            @endif
        @endforeach
    </ul>
</nav>
