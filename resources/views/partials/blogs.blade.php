<div class="blog_style__one bg-body section_gap_y_bottom__1">
    <div class="container">
        <div class="row gy-4 align-items-end">
            <div class="col-md-7">
                <span class="sub-header-2">En Popüler</span>
                <h2 class="section_title__2">Popüler Prompt Koleksiyonları</h2>
            </div>
            <div class="col-md-5 text-md-end">
                <a class="btn-rounded-v3">Tüm Yazıları Görüntüle</a>
            </div>
        </div>
        <div class="row pt-50">
            <div class="col-lg-12">
                @foreach($recentBlogs as $blog)
                    @include('partials.blog-card', ['blog' => $blog])
                @endforeach
            </div>
        </div>
    </div>
</div>