@php
  use App\Models\Faq;

  $firstSegment = request()->segment(1);
  $pageKey = match ($firstSegment) {
    null => 'home',
    'service' => 'service',
    'service-details' => 'service_details',
    'case-studies' => 'case_studies',
    'blog', 'blog-details' => 'blog',
    default => str_replace('-', '_', $firstSegment),
  };

  $faqs = Faq::where('page_key', $pageKey)
    ->where('is_active', true)
    ->orderBy('sort_order')
    ->latest()
    ->get();
@endphp

@if($faqs->isNotEmpty())
  <section class="faq-section py-5 tcw-faq-section">
    <div class="container">
      <div class="row align-items-center mb-4">
        <div class="col-12">
          <h2 class="mb-0">{{ __('website.faq.title') }}</h2>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          @foreach($faqs as $faq)
            <div class="faq-item mb-3">
              <h4 class="faq-question p-3 fw-bold">{{ $faq->localized('question') }}</h4>
              <div class="faq-answer px-3">
                <div class="faq-answer-content">{!! $faq->formatted_answer !!}</div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
@endif
