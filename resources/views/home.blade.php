@extends('layouts.app')

@section('content')
    <main class="theme-dark-active">
        @php
            $sections = [
                'partials.hero',
                'partials.categories',
                'partials.sellers',
                'partials.prompt-grid',
                'partials.artists',
                'partials.community',
                'partials.blogs'
            ];
        @endphp

        @foreach($sections as $section)
            @include($section)
        @endforeach
</main>
@endsection
