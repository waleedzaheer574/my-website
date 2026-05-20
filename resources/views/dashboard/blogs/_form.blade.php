<div class="form-group">
    <label for="title">Blog Title</label>
    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $blog->title ?? '') }}" required>
    @error('title') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="admin-u-022">
    <div class="form-group">
        <label for="author_name">Author Name</label>
        <input type="text" name="author_name" id="author_name" class="form-control" value="{{ old('author_name', $blog->author_name ?? '') }}" required>
        @error('author_name') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="category">Category</label>
        <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $blog->category ?? '') }}" placeholder="UI/UX">
        @error('category') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="admin-u-022">
    <div class="form-group">
        <label for="featured_image">Featured Image</label>
        @if(!empty($blog?->featured_image))
            <div class="admin-u-019">
                <img class="admin-u-075" src="{{ asset($blog->featured_image) }}" alt="">
            </div>
        @endif
        <input type="file" name="featured_image" id="featured_image" class="form-control" accept="image/*" {{ empty($blog) ? 'required' : '' }}>
        @error('featured_image') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="author_image">Author Image</label>
        @if(!empty($blog?->author_image))
            <div class="admin-u-019">
                <img class="admin-u-075" src="{{ asset($blog->author_image) }}" alt="">
            </div>
        @endif
        <input type="file" name="author_image" id="author_image" class="form-control" accept="image/*">
        @error('author_image') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="form-group">
    <label for="excerpt">Short Description</label>
    <textarea name="excerpt" id="excerpt" class="form-control" rows="4" placeholder="Short text for blog listing">{{ old('excerpt', $blog->excerpt ?? '') }}</textarea>
    @error('excerpt') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="content">Blog Content</label>
    <textarea name="content" id="content" class="form-control" rows="10" required>{{ old('content', $blog->content ?? '') }}</textarea>
    @error('content') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="author_bio">Author Bio</label>
    <textarea name="author_bio" id="author_bio" class="form-control" rows="4">{{ old('author_bio', $blog->author_bio ?? '') }}</textarea>
    @error('author_bio') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="admin-u-023">
    <div class="form-group">
        <label for="published_at">Publish Date</label>
        <input type="datetime-local" name="published_at" id="published_at" class="form-control" value="{{ old('published_at', isset($blog?->published_at) ? $blog->published_at->format('Y-m-d\\TH:i') : '') }}">
        @error('published_at') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="views">Views</label>
        <input type="number" min="0" name="views" id="views" class="form-control" value="{{ old('views', $blog->views ?? 0) }}">
        @error('views') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="is_active">Status</label>
        <select name="is_active" id="is_active" class="form-control">
            <option value="1" {{ (string) old('is_active', $blog->is_active ?? 1) === '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ (string) old('is_active', $blog->is_active ?? 1) === '0' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('is_active') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>
