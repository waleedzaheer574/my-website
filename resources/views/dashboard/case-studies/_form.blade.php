@php
    $isEdit = !is_null($caseStudy);
@endphp

<div class="admin-u-035">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $caseStudy?->title) }}" required>
        @error('title') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $caseStudy?->category) }}" placeholder="Real Estate">
        @error('category') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="form-group">
    <label for="summary">Summary</label>
    <textarea name="summary" id="summary" class="form-control" rows="5">{{ old('summary', $caseStudy?->summary) }}</textarea>
    @error('summary') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<h3>Arabic Content</h3>
@foreach(['title_ar' => 'Title (Arabic)', 'category_ar' => 'Category (Arabic)', 'result_ar' => 'Result / Metric (Arabic)'] as $field => $label)
    <div class="form-group">
        <label for="{{ $field }}">{{ $label }}</label>
        <input type="text" name="{{ $field }}" id="{{ $field }}" class="form-control" dir="rtl" lang="ar" value="{{ old($field, $caseStudy?->{$field}) }}">
        @error($field) <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
@endforeach
<div class="form-group">
    <label for="summary_ar">Summary (Arabic)</label>
    <textarea name="summary_ar" id="summary_ar" class="form-control" dir="rtl" lang="ar" rows="5">{{ old('summary_ar', $caseStudy?->summary_ar) }}</textarea>
    @error('summary_ar') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="admin-u-035">
    <div class="form-group">
        <label for="result">Result / Metric</label>
        <input type="text" name="result" id="result" class="form-control" value="{{ old('result', $caseStudy?->result) }}" placeholder="Leads up 42%">
        @error('result') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="cta_url">CTA URL</label>
        <input type="url" name="cta_url" id="cta_url" class="form-control" value="{{ old('cta_url', $caseStudy?->cta_url) }}" placeholder="{{ url('/contact') }}">
        @error('cta_url') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="admin-u-036">
    <div class="form-group">
        <label for="image">Card Image</label>
        @if($isEdit && $caseStudy->image)
            <img class="admin-u-077" src="{{ asset($caseStudy->image) }}" alt="{{ $caseStudy->localized('title') }}">
        @endif
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
        @error('image') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="sort_order">Sort Order</label>
        <input type="number" name="sort_order" id="sort_order" class="form-control" min="0" value="{{ old('sort_order', $caseStudy?->sort_order ?? 0) }}">
        @error('sort_order') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="admin-u-037">
        <label class="admin-u-038">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $caseStudy?->is_active ?? true) ? 'checked' : '' }}>
            Active
        </label>
    </div>
</div>
