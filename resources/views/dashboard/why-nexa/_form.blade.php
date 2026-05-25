@php
    $isEdit = !is_null($whyNexa);
@endphp

<div class="admin-u-035">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $whyNexa?->title) }}" required>
        @error('title') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="sort_order">Sort Order</label>
        <input type="number" name="sort_order" id="sort_order" class="form-control" min="0" value="{{ old('sort_order', $whyNexa?->sort_order ?? 0) }}">
        @error('sort_order') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $whyNexa?->description) }}</textarea>
    @error('description') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<h3>Arabic Content</h3>
<div class="form-group">
    <label for="title_ar">Title (Arabic)</label>
    <input type="text" name="title_ar" id="title_ar" class="form-control" dir="rtl" lang="ar" value="{{ old('title_ar', $whyNexa?->title_ar) }}">
    @error('title_ar') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>
<div class="form-group">
    <label for="description_ar">Description (Arabic)</label>
    <textarea name="description_ar" id="description_ar" class="form-control" dir="rtl" lang="ar" rows="5">{{ old('description_ar', $whyNexa?->description_ar) }}</textarea>
    @error('description_ar') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="admin-u-042">
    <div class="form-group">
        <label for="icon">Icon Image</label>
        @if($isEdit && $whyNexa->icon)
            <img class="admin-u-079" src="{{ asset($whyNexa->icon) }}" alt="{{ $whyNexa->title }}">
        @endif
        <input type="file" name="icon" id="icon" class="form-control" accept="image/*">
        @error('icon') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="admin-u-037">
        <label class="admin-u-038">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $whyNexa?->is_active ?? true) ? 'checked' : '' }}>
            Active
        </label>
    </div>
</div>
