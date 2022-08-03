<section class="section blog single">
    <div class="container">
        <div class="row gap-y">
            <div class="col-lg-8 b-l order-lg-2">
                <div class="blog-post post-content pb-5">
                    @include ("frontends.blog.post._post")
                </div>

                <div class="post-author py-5 b-t b-2x">
                    @include ("frontends.blog.post._author")
                </div>

                <div class="post-details py-5 b-t">
                    @include ("frontends.blog.post._details")
                </div>

                <div class="post-comments b-t p-4">
                    @include ("frontends.blog.post._leave-comment")
                </div>
            </div>

            <div class="col-lg-4">
                @include ("frontends.blog.post._sidebar")
            </div>
        </div>
    </div>
</section>
