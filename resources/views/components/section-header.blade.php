<div class="row gy-4 align-items-end">
    <div class="col-lg-6">
        @if($subtitle)
            <span class="sub-header-2">{{ $subtitle }}</span>
        @endif
        <h2 class="section_title__2">{{ $title }}</h2>
        @if($description ?? false)
            <p class="disc-text pt-2">{{ $description }}</p>
        @endif
    </div>
    <div class="col-lg-6 d-flex justify-content-lg-end align-items-center">
        @if($showNavigation ?? false)
            <div class="slider__nav d-flex mr-3">
                <div class="{{ $prevClass }} navigation_btn_2 btn__prev mr-1">
                    <i class="bi bi-chevron-left"></i>
                </div>
                <div class="{{ $nextClass }} navigation_btn_2 btn__next">
                    <i class="bi bi-chevron-right"></i>
                </div>
            </div>
        @endif
        <a class="btn-rounded-v3" href="{{ $viewAllUrl }}">{{ $viewAllText }}</a>
    </div>
</div>