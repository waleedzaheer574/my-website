@php
  $blogs = $blogs ?? collect();
  $emptyText = $emptyText ?? 'No blogs found.';
@endphp


<div class="tcw-blog-rail" data-blog-rail>
  <div class="tcw-blog-rail_wrap" data-blog-rail-wrap>
    <button class="tcw-blog-rail_arrow tcw-blog-rail_prev" type="button" data-blog-rail-prev aria-label="Previous blog">
      <i class="fas fa-angle-left"></i>
    </button>
    <button class="tcw-blog-rail_arrow tcw-blog-rail_next" type="button" data-blog-rail-next aria-label="Next blog">
      <i class="fas fa-angle-right"></i>
    </button>

    <div class="tcw-blog-rail_track" data-blog-rail-track>
      @forelse($blogs as $blog)
        <div class="tcw-blog-rail_slide" data-blog-rail-slide>
          <a href="{{ route('website.blog-details.show', $blog->slug) }}" class="tcw-blog-card">
            <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}" loading="lazy" decoding="async">
            <span class="tcw-blog-card_content">
              <span class="tcw-blog-card_meta">{{ $blog->category ?: $blog->author_name }}</span>
              <h3 class="tcw-blog-card_title">{{ $blog->title }}</h3>
            </span>
          </a>
        </div>
      @empty
        <div class="tcw-blog-rail_empty">{{ $emptyText }}</div>
      @endforelse
    </div>
  </div>
</div>
