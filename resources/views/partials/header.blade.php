<header>
    <div class="header-area header-defult header_style__three bg-body sticky">
        <div class="container">
            @include('components.mobile-search')

            <div class="row justify-content-between">
                <div class="col-xl-4 col-2 col-lg-3 col-md-2 align-items-center d-flex order-0">
                    <div class="nav-logo logo-switch d-flex justify-content-between align-items-center">
                        <a class="logo-dark" href="/">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="logo">
                        </a>
                        <a class="logo-light" href="/">
                            <img src="{{ asset('assets/images/logo-v2.png') }}" alt="logo">
                        </a>
                    </div>
                    <div class="nav-search-style-three w-100 d-xl-block d-none">
                    <span class="search__icon">
                        <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.26847 16.0378C12.2827 16.0378 15.5369 12.7834 15.5369 8.7689C15.5369 4.7544 12.2827 1.5 8.26847 1.5C4.2542 1.5 1 4.7544 1 8.7689C1 12.7834 4.2542 16.0378 8.26847 16.0378Z"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <path d="M17.0002 17.5L13.4023 13.9025" stroke="currentColor" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </span>
                        <input type="text" name="search" placeholder="Koleksiyon, öğe veya kullanıcı"
                               spellcheck="false">
                    </div>
                </div>
                <div class="col-xl-8 col-10 col-lg-9 d-flex justify-content-end">
                    @include('components.navigation')
                    <div class="nav-actions d-flex align-items-center">
                        <div class="d-none d-md-block mr-2">
                            <a class="nav-three-btn" href="/connect-wallet">
                                <span>Hesabınıza Giriş Yapın</span>
                            </a>
                        </div>
                        <button type="button" class="mobile-menu-btn d-block d-xl-none" id="navSearch">
                            <div class="hamburger">
                                <span class="h-top"></span>
                                <span class="h-middle"></span>
                                <span class="h-bottom"></span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
