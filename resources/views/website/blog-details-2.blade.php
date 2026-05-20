@extends('layouts.website')

@section('content')
  <div class="cs-height_90 cs-height_lg_780"></div>
  <hr class="cs-accent_15_bg">

  <!-- Start Blog Details -->
  <div class="cs-blog_details cs-style1 cs-type1">
    <div class="cs-bg" data-src="{{ asset('website/assets/img/design-agency/icon-box-bg2.jpg') }}">
      <div class="cs-height_130 cs-height_lg_70"></div>
      <div class="cs-blog_details_head">
        <div class="cs-left text-center">
          <img src="{{ asset('website/assets/img/digital-agency/post-details-1.jpg') }}" alt="Image">
          <div class="cs-height_10 cs-height_lg_0"></div>
          <div class="cs-social_btns cs-style1 cs-center">
            <a href="#" class="cs-accent_10_bg cs-white_hover cs-accent_bg_hover cs-accent_color"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="cs-accent_10_bg cs-white_hover cs-accent_bg_hover cs-accent_color"><i class="fab fa-twitter"></i></a>
            <a href="#" class="cs-accent_10_bg cs-white_hover cs-accent_bg_hover cs-accent_color"><i class="fab fa-instagram"></i></a>
            <a href="#" class="cs-accent_10_bg cs-white_hover cs-accent_bg_hover cs-accent_color"><i class="fab fa-pinterest-p"></i></a>
          </div>
        </div>
        <div class="cs-right">
          <div class="cs-blog_details_info">
            <div class="cs-blog_details_meta">
              <div class="cs-posted_by">
                <span>By</span> <a href="#" class="cs-primary_color">Michle Smith </a> <span>on</span> <a href="#" class="cs-primary_color">UI/UX</a>
              </div>
              <div class="cs-post_date"><i class="far fa-calendar-alt"></i> 26 Feb, 2020</div>
            </div>
            <div class="cs-height_25 cs-height_lg_25"></div>
            <h1 class="cs-blog_details_title">20 most interesting UX design case studies to inspire you.</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="cs-height_80 cs-height_lg_60"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 offset-lg-2">
          <p>In the first place we have granted to God, and by this our present charter confirmed for us and our heirs forever that the English Church shall be free, and shall have her rights entire, and her liberties inviolate; and we will that it be thus observed; which is apparent from this that the freedom of elections, which is reckoned most important and very essential to the English Church, we, of our pure and unconstrained will, did grant <br><br>Pope Innocent III, before the quarrel arose between us and our barons: and this we will observe, and our will is that it be observed in good faith by our heirs forever. We have also granted to all freemen of our kingdom, for us and our heirs forever.</p>
          <img src="{{ asset('website/assets/img/digital-agency/post-details-2.jpg') }}" alt="Image">
          <h4>And Eurypylus, son of Euaemon, killed Hypsenor</h4>
          <p>The son of noble Dolopion, who had been made priest of the river Scamander, and was honoured among the people as though he were a god. Eurypylus gave him chase as he was flying before him, smote him with his sword upon the arm, and lopped his strong hand from off it.</p>
          <blockquote><p>The bloody hand fell to the ground, and the shades of death, with fate that no man can withstand, came over his eyes. Thus furiously did the battle rage between them. As for the son of Tydeus.</p><cite>Jhon Doe</cite></blockquote>
          <p> He rushed across the plain like a winter torrent that has burst its barrier in full flood; no dykes, no walls of fruitful vineyards can embank it when it is swollen with rain from heaven</p>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="cs-height_20 cs-height_lg_20"></div>
        <div class="cs-author cs-style1 cs-accent_4_bg">
          <div class="cs-author-img"><img src="{{ asset('website/assets/img/digital-agency/avatar1.jpg') }}" alt=""></div>
          <div class="cs-author-right">
            <div class="cs-author_title">About author</div>
            <h2 class="cs-author_name cs-accent_color">Sarah Taylor</h2>
            <div class="cs-author_desc">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. </div>
          </div>
        </div>
        <div class="cs-height_70 cs-height_lg_70"></div>
        <div id="respond" class="comment-respond">
          <h3 id="reply-title" class="comment-reply-title cs-semi_bold">Leave a comment</h3>
          <form action="#" method="post" id="commentform" class="comment-form tb-comment-form cs-accent_4_bg">
            <p class="comment-form-comment">
              <textarea placeholder="Comment" id="comment" cols="45" rows="8"></textarea>
            </p>
            <p class="comment-form-author">
              <input id="author" placeholder="Name" type="text">
            </p>
            <p class="comment-form-email">
              <input id="email" placeholder="Email" name="email" type="text">
            </p>
            <p class="form-submit">
              <input name="submit" type="submit" id="submit" class="cs-comment_btn cs-medium cs-white cs-accent_bg cs-accent_bg_2_hover" value="Post Comment">
            </p>
          </form>
        </div>
        <div class="cs-height_70 cs-height_lg_70"></div>
        <div id="comments" class="comments-area">
          <h2 class="comments-title cs-semi_bold">Comments</h2>
          <ol class="comment-list">
            <li class="comment cs-accent_4_bg">
              <div class="comment-body">
                <div class="comment-author vcard">
                  <img class="avatar" src="{{ asset('website/assets/img/digital-agency/avatar2.jpg') }}" alt="Author"> 
                  <a href="#" class="url">George Steven</a>
                </div>
                <div class="comment-meta">
                  <a href="#">Jan 24, 2022 at 9:59 am </a>
                </div>
                <p>Hi, <br/>
                  Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient </p>
                <div class="reply"><a class="comment-reply-link" href="#">Reply</a></div>
              </div>
              <ol class="children">
                <li class="comment">
                  <div class="comment-body">
                    <div class="comment-author vcard">
                      <img class="avatar" src="{{ asset('website/assets/img/digital-agency/avatar1.jpg') }}" alt="Author"> 
                      <a href="#" class="url">Sarah Taylor</a>
                    </div>
                    <div class="comment-meta">
                      <a href="#">Jan 24, 2022 at 9:59 am </a>
                    </div>
                    <p>Thanks bro 🙂</p>
                    <div class="reply"><a class="comment-reply-link" href="#">Reply</a></div>
                  </div>
                </li><!-- #comment-## -->
              </ol><!-- .children -->
            </li><!-- #comment-## -->
            <li class="comment cs-accent_4_bg">
              <div class="comment-body">
                <div class="comment-author vcard">
                  <img class="avatar" src="{{ asset('website/assets/img/digital-agency/avatar3.jpg') }}" alt="Author"> 
                  <a href="#" class="url">Jhon Doe</a>
                </div>
                <div class="comment-meta">
                  <a href="#">Jan 24, 2022 at 9:59 am </a>
                </div>
                <p>Awesome Theme 🙂</p>
                <div class="reply"><a class="comment-reply-link" href="#">Reply</a></div>
              </div>
            </li><!-- #comment-## -->
          </ol><!-- .comment-list -->
        </div>
      </div>
    </div>
  </div>
  <div class="cs-height_140 cs-height_lg_80"></div>
  <div class="container">
    <hr class="cs-accent_20_bg">
    <div class="cs-height_130 cs-height_lg_70"></div>
    <h2>Related <b class="cs-accent_color cs-with_bar">
      articles
      <svg width="208" height="11" viewBox="0 0 208 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="cs-accent_color_2">
        <path d="M8.90002 10.1C72.2 10.6 135.6 10.7 198.9 10.5C200.8 10.5 200.8 7.49998 198.9 7.49998C135.6 7.79998 72.2 7.69998 8.90002 7.09998C6.90002 7.09998 6.90002 10.1 8.90002 10.1Z" fill="currentColor"></path>
        <path d="M1.90002 3.79999C69.9 3.79999 137.9 4.09999 205.9 4.89999C207.8 4.89999 207.8 1.89999 205.9 1.89999C137.9 1.19999 69.9 0.799988 1.90002 0.799988C-0.0999756 0.799988 -0.0999756 3.79999 1.90002 3.79999Z" fill="currentColor"></path>
      </svg> 
    </b></h2>
    <div class="cs-height_40 cs-height_lg_20"></div>
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="cs-post cs-style1">
          <a href="{{ url('/blog-details') }}" class="cs-post_thumb">
            <div class="cs-post_thumb_in cs-bg" data-src="{{ asset('website/assets/img/digital-agency/post1.jpg') }}"></div>
          </a>
          <div class="cs-post_label">
            <div class="cs-post_categories cs-style1">
              <ul class="post-categories">
                <li><a href="{{ url('/blog') }}" class="cs-accent_color_hover">Digital Agency</a></li>
              </ul>
            </div>
            <div class="cs-post_date">12 Jan, 2022</div>
          </div>
          <h2 class="cs-post_title"><a href="{{ url('/blog-details') }}">How to grow a creative digital agency </a></h2>
        </div>
        <div class="cs-height_30 cs-height_lg_30"></div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="cs-post cs-style1">
          <a href="{{ url('/blog-details') }}" class="cs-post_thumb">
            <div class="cs-post_thumb_in cs-bg" data-src="{{ asset('website/assets/img/digital-agency/post2.jpg') }}"></div>
          </a>
          <div class="cs-post_label">
            <div class="cs-post_categories cs-style1">
              <ul class="post-categories">
                <li><a href="{{ url('/blog') }}" class="cs-accent_color_hover">Digital Agency</a></li>
              </ul>
            </div>
            <div class="cs-post_date">12 Jan, 2022</div>
          </div>
          <h2 class="cs-post_title"><a href="{{ url('/blog-details') }}">The future of the digital agency business? </a></h2>
        </div>
        <div class="cs-height_30 cs-height_lg_30"></div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="cs-post cs-style1">
          <a href="{{ url('/blog-details') }}" class="cs-post_thumb">
            <div class="cs-post_thumb_in cs-bg" data-src="{{ asset('website/assets/img/digital-agency/post3.jpg') }}"></div>
          </a>
          <div class="cs-post_label">
            <div class="cs-post_categories cs-style1">
              <ul class="post-categories">
                <li><a href="{{ url('/blog') }}" class="cs-accent_color_hover">Digital Agency</a></li>
              </ul>
            </div>
            <div class="cs-post_date">12 Jan, 2022</div>
          </div>
          <h2 class="cs-post_title"><a href="{{ url('/blog-details') }}">How to create simplest and most beautiful.</a></h2>
        </div>
        <div class="cs-height_30 cs-height_lg_30"></div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="cs-post cs-style1">
          <a href="{{ url('/blog-details') }}" class="cs-post_thumb">
            <div class="cs-post_thumb_in cs-bg" data-src="{{ asset('website/assets/img/digital-agency/post4.jpg') }}"></div>
          </a>
          <div class="cs-post_label">
            <div class="cs-post_categories cs-style1">
              <ul class="post-categories">
                <li><a href="{{ url('/blog') }}" class="cs-accent_color_hover">Digital Agency</a></li>
              </ul>
            </div>
            <div class="cs-post_date">12 Jan, 2022</div>
          </div>
          <h2 class="cs-post_title"><a href="{{ url('/blog-details') }}">20 most interesting UX design case studies. </a></h2>
        </div>
        <div class="cs-height_30 cs-height_lg_30"></div>
      </div>
    </div>
    <div class="cs-height_100 cs-height_lg_50"></div>
  </div>
  <!-- End Blog Details -->
@endsection
