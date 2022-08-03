@php
        use WebDevEtc\BlogEtc\Captcha\CaptchaAbstract;
        use WebDevEtc\BlogEtc\Models\Post;
        /** @var Post $post */
        /** @var CaptchaAbstract $captcha */
    @endphp
    @can(\WebDevEtc\BlogEtc\Gates\GateTypes::ADD_COMMENT)
      <!-- Leave a Blog Comment -->
      <div class="col-12 mt-1">
        <h6 class="section-label mt-25">Leave a Comment</h6>
        <div class="card">
          <div class="card-body">
            <form method="post" action="{{ route('blogetc.comments.add_new_comment', $post->slug) }}">
                @csrf
              <div class="row">
                @if(config("blogetc.comments.save_user_id_if_logged_in", true) === false || !Auth::check())
                    <div class="col-sm-6 col-12">
                        <div class="mb-2">
                            <input
                                            type="text"
                                            class="form-control"
                                            name="author_name"
                                            id="author_name"
                                            placeholder="Your name"
                                            required
                                            value="{{old("author_name")}}">
                        </div>
                    </div>
                    @if(config("blogetc.comments.ask_for_author_email"))
                        <div class="col-sm-6 col-12">
                        <div class="mb-2">
                            <input
                                        type="email"
                                        class="form-control"
                                        name="author_email"
                                        id="author_email"
                                        placeholder="Your Email"
                                        required
                                        value="{{old("author_email")}}">
                        </div>
                        </div>
                    @endif
                @endif
                @if(config("blogetc.comments.ask_for_author_website"))
                    <div class="col-sm-6 col-12">
                        <div class="mb-2">
                            <input
                                        type="url"
                                        class="form-control"
                                        name="author_website"
                                        id="author_website"
                                        placeholder="Your Website URL"
                                        value="{{old("author_website")}}">
                        </div>
                    </div>
                @endif

                <div class="col-12">
                  <textarea
                        class="form-control mb-2"
                        rows="4"
                        name="comment"
                        required
                        id="comment"
                        placeholder="Write your comment here"
                        rows="7">{{ old('comment') }}</textarea>
                </div>
                <div class="col-12 mb-2">
                    @if($captcha)
                        {{-- Captcha is enabled. Load the type class and then include the view as defined in the captcha class. --}}
                        @include($captcha->view())
                    @endif
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary">Post Comment</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!--/ Leave a Blog Comment -->
      @endcan
