<div class="breadcrumb_style__one bg-body-2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <h2 class="page__title">{{ $title }}</h2>
                <ul class="d-flex justify-content-center page__list">
                    <li><a href="/">Anasayfa</a></li>
                    @if(isset($breadcrumbs))
                        @foreach($breadcrumbs as $breadcrumb)
                            @if($loop->last)
                                <li>{{ $breadcrumb['title'] }}</li>
                            @else
                                <li><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a></li>
                            @endif
                        @endforeach
                    @else
                        <li>{{ $title }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>