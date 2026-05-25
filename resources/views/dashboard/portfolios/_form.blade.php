@php
    $isEdit = !is_null($portfolio);
@endphp

<div class="admin-u-035">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $portfolio?->title) }}" required>
        @error('title') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $portfolio?->category) }}" placeholder="Web Design">
        @error('category') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="admin-u-035">
    <div class="form-group">
        <label for="client">Client</label>
        <input type="text" name="client" id="client" class="form-control" value="{{ old('client', $portfolio?->client) }}" placeholder="Client name">
        @error('client') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="duration">Duration</label>
        <input type="text" name="duration" id="duration" class="form-control" value="{{ old('duration', $portfolio?->duration) }}" placeholder="10/01/2026 - 30/01/2026">
        @error('duration') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="admin-u-035">
    <div class="form-group">
        <label for="tags">Tags</label>
        <input type="text" name="tags" id="tags" class="form-control" value="{{ old('tags', $portfolio?->tags) }}" placeholder="Design, Development, Branding">
        @error('tags') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="demo_url">Demo URL</label>
        <input type="url" name="demo_url" id="demo_url" class="form-control" value="{{ old('demo_url', $portfolio?->demo_url) }}" placeholder="https://example.com">
        @error('demo_url') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="form-group">
    <label for="short_description">Short Description</label>
    <textarea name="short_description" id="short_description" class="form-control" rows="3">{{ old('short_description', $portfolio?->short_description) }}</textarea>
    @error('short_description') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="description">Project Description</label>
    <textarea name="description" id="description" class="form-control" rows="6">{{ old('description', $portfolio?->description) }}</textarea>
    @error('description') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<h3>Arabic Content</h3>
<div class="admin-u-035">
    @foreach(['title_ar' => 'Title (Arabic)', 'category_ar' => 'Category (Arabic)', 'tags_ar' => 'Tags (Arabic)', 'duration_ar' => 'Duration (Arabic)'] as $field => $label)
        <div class="form-group">
            <label for="{{ $field }}">{{ $label }}</label>
            <input type="text" name="{{ $field }}" id="{{ $field }}" class="form-control" dir="rtl" lang="ar" value="{{ old($field, $portfolio?->{$field}) }}">
            @error($field) <small class="admin-u-021">{{ $message }}</small> @enderror
        </div>
    @endforeach
</div>
@foreach(['short_description_ar' => 'Short Description (Arabic)', 'description_ar' => 'Project Description (Arabic)'] as $field => $label)
    <div class="form-group">
        <label for="{{ $field }}">{{ $label }}</label>
        <textarea name="{{ $field }}" id="{{ $field }}" class="form-control" dir="rtl" lang="ar" rows="{{ $field === 'description_ar' ? 6 : 3 }}">{{ old($field, $portfolio?->{$field}) }}</textarea>
        @error($field) <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
@endforeach

<div class="admin-u-051">
    <div class="form-group">
        <label for="image">Main Image</label>
        @if($isEdit && $portfolio->image)
            <img class="admin-u-083" src="{{ asset($portfolio->image) }}" alt="{{ $portfolio->title }}">
        @endif
        <input type="file" name="image" id="image" class="form-control" accept="image/*" {{ $isEdit ? '' : 'required' }}>
        @error('image') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="secondary_image">Secondary Image</label>
        @if($isEdit && $portfolio->secondary_image)
            <img class="admin-u-083" src="{{ asset($portfolio->secondary_image) }}" alt="{{ $portfolio->title }}">
        @endif
        <input type="file" name="secondary_image" id="secondary_image" class="form-control" accept="image/*">
        @error('secondary_image') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="detail_image">Detail Image</label>
        @if($isEdit && $portfolio->detail_image)
            <img class="admin-u-083" src="{{ asset($portfolio->detail_image) }}" alt="{{ $portfolio->title }}">
        @endif
        <input type="file" name="detail_image" id="detail_image" class="form-control" accept="image/*">
        @error('detail_image') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="admin-u-052">
    <div class="form-group">
        <label for="sort_order">Sort Order</label>
        <input type="number" name="sort_order" id="sort_order" class="form-control" min="0" value="{{ old('sort_order', $portfolio?->sort_order ?? 0) }}">
        @error('sort_order') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="admin-u-053">
        <label class="admin-u-038">
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $portfolio?->is_featured) ? 'checked' : '' }}>
            Featured on Home
        </label>
        <label class="admin-u-038">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $portfolio?->is_active ?? true) ? 'checked' : '' }}>
            Active
        </label>
    </div>
</div>
