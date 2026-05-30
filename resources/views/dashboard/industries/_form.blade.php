@php
    $isEdit = !is_null($industry);
@endphp

<div class="admin-u-035">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $industry?->title) }}" required>
        @error('title') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="sort_order">Sort Order</label>
        <input type="number" name="sort_order" id="sort_order" class="form-control" min="0" value="{{ old('sort_order', $industry?->sort_order ?? 0) }}">
        @error('sort_order') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="admin-u-035">
    <div class="form-group">
        <label for="category">Category</label>
        <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $industry?->category) }}" placeholder="Industry">
        @error('category') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="result">Result / Metric</label>
        <input type="text" name="result" id="result" class="form-control" value="{{ old('result', $industry?->result) }}" placeholder="Focused Solutions">
        @error('result') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $industry?->description) }}</textarea>
    @error('description') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<h3>Arabic Content</h3>
@foreach(['title_ar' => 'Title (Arabic)', 'category_ar' => 'Category (Arabic)', 'result_ar' => 'Result / Metric (Arabic)'] as $field => $label)
    <div class="form-group">
        <label for="{{ $field }}">{{ $label }}</label>
        <input type="text" name="{{ $field }}" id="{{ $field }}" class="form-control" dir="rtl" lang="ar" value="{{ old($field, $industry?->{$field}) }}">
        @error($field) <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
@endforeach
<div class="form-group">
    <label for="description_ar">Description (Arabic)</label>
    <textarea name="description_ar" id="description_ar" class="form-control" dir="rtl" lang="ar" rows="5">{{ old('description_ar', $industry?->description_ar) }}</textarea>
    @error('description_ar') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="cta_url">CTA URL</label>
    <input type="url" name="cta_url" id="cta_url" class="form-control" value="{{ old('cta_url', $industry?->cta_url) }}" placeholder="{{ url('/contact') }}">
    @error('cta_url') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="admin-u-042">
    <div class="form-group">
        <label for="icon">Icon Image</label>
        @if($isEdit && $industry->icon)
            <img class="admin-u-079" src="{{ asset($industry->icon) }}" alt="{{ $industry->localized('title') }}">
        @endif
        <input type="file" name="icon" id="icon" class="form-control" accept="image/*">
        @error('icon') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="admin-u-037">
        <label class="admin-u-038">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $industry?->is_active ?? true) ? 'checked' : '' }}>
            Active
        </label>
    </div>
</div>
