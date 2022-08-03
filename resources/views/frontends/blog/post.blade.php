<x-utils.container class="blog-post" id="blog-post">
    <div class="row">
        <div class="col-md-8 mx-auto">
            @include ("frontends.blog.post._post")
        </div>
    </div>
</x-utils.container>

{{-- <x-utils.container container-class="py-5 border-top b-2x">
    @include ("frontend.blog.post._author")
</x-utils.container> --}}

<x-utils.container container-class="py-5 border-top">
    @include ("frontends.blog.post._details")
</x-utils.container>

<x-utils.container class="post-comments bg-light border-top">
    <div class="row">
        <div class="col-lg-8 mx-lg-auto">

            @include ("frontends.blog.post._comments")
            <!-- Blog Comment -->
                @if(config("blogetc.comments.type_of_comments_to_show","built_in") !== 'disabled')
                    <div id="maincommentscontainer">
                        <div class="col-12 mt-1" id="blogComment">
                            @switch(config("blogetc.comments.type_of_comments_to_show","built_in"))

                            @case("built_in")
                            @include("blogetc::partials.add_comment_form")
                            @break

                            @case("disqus")
                            @include("blogetc::partials.disqus_comments")
                            @break


                            @case("custom")
                            @include("blogetc::partials.custom_comments")
                            @break

                            @case("disabled")
                            <?php
                            return;  // not required, as we already filter for this
                            ?>
                            @break

                            @default
                            <div class="alert alert-danger">
                                Invalid comment <code>type_of_comments_to_show</code> config option
                            </div>
                        @endswitch

                        </div>
                    </div>
                @endif
            <!--/ Blog Comment -->
        </div>
    </div>
</x-utils.container>

<x-utils.container class="bg-light border-top">
    @include ("frontends.blog.post._recommended")
</x-utils.container>
