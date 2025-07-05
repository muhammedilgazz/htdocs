<div class="{{ $containerClass }} pt-40">
    <div class="swiper">
        <div class="swiper-wrapper">
            {{ $slot }}
        </div>
        <div class="swiper-button-prev {{ $prevClass }}"></div>
        <div class="swiper-button-next {{ $nextClass }}"></div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/' . $scriptFile) }}"></script>
@endpush