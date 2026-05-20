@php
    $isEdit = !is_null($review);
@endphp

<div class="admin-u-035">
    <div class="form-group">
        <label for="client_name">Client Name</label>
        <input type="text" name="client_name" id="client_name" class="form-control" value="{{ old('client_name', $review?->client_name) }}" required>
        @error('client_name') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="designation">Designation</label>
        <input type="text" name="designation" id="designation" class="form-control" value="{{ old('designation', $review?->designation) }}" placeholder="Marketing Lead">
        @error('designation') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="admin-u-035">
    <div class="form-group">
        <label for="badge">Badge</label>
        <input type="text" name="badge" id="badge" class="form-control" value="{{ old('badge', $review?->badge) }}" placeholder="New, Growth, SEO">
        @error('badge') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="rating">Rating Stars</label>
        <select name="rating" id="rating" class="form-control">
            @for($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" {{ (int) old('rating', $review?->rating ?? 5) === $i ? 'selected' : '' }}>
                    {{ $i }} {{ \Illuminate\Support\Str::plural('star', $i) }}
                </option>
            @endfor
        </select>
        @error('rating') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="admin-u-035">
    <div class="form-group">
        <label for="sort_order">Sort Order</label>
        <input type="number" name="sort_order" id="sort_order" class="form-control" min="0" value="{{ old('sort_order', $review?->sort_order ?? 0) }}">
        @error('sort_order') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="form-group">
    <label for="review_text">Client Review</label>
    <textarea name="review_text" id="review_text" class="form-control" rows="6" placeholder="Write the client feedback that will appear on the website slider." required>{{ old('review_text', $review?->review_text) }}</textarea>
    @error('review_text') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="admin-u-058">
    <label class="admin-u-038">
        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $review?->is_featured) ? 'checked' : '' }}>
        Featured
    </label>
    <label class="admin-u-038">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $review?->is_active ?? true) ? 'checked' : '' }}>
        Show in Slider
    </label>
</div>
