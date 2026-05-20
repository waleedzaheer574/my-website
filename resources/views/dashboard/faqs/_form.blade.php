@php
    use App\Models\Faq;

    $isEdit = !is_null($faq);
@endphp

<div class="admin-u-035">
    <div class="form-group">
        <label for="page_key">Page</label>
        <select name="page_key" id="page_key" class="form-control" required>
            <option value="">Select Page</option>
            @foreach(Faq::PAGE_OPTIONS as $key => $label)
                <option value="{{ $key }}" {{ old('page_key', $faq?->page_key) === $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('page_key') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="sort_order">Sort Order</label>
        <input type="number" name="sort_order" id="sort_order" class="form-control" min="0" value="{{ old('sort_order', $faq?->sort_order ?? 0) }}">
        @error('sort_order') <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
</div>

<div class="form-group">
    <label for="question">Question</label>
    <input type="text" name="question" id="question" class="form-control" value="{{ old('question', $faq?->question) }}" required>
    @error('question') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="answer">Answer</label>
    <div class="admin-rich-toolbar" aria-label="FAQ answer formatting tools">
        <button type="button" data-rich-action="bold" data-rich-target="answer"><strong>B</strong></button>
        <button type="button" data-rich-action="underline" data-rich-target="answer"><u>U</u></button>
        <button type="button" data-rich-action="bullet" data-rich-target="answer">&bull; List</button>
    </div>
    <textarea name="answer" id="answer" class="form-control" rows="6" required>{{ old('answer', $faq?->answer) }}</textarea>
    <small class="admin-rich-hint">Text select karke Bold, Underline, ya List button press karein.</small>
    @error('answer') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<label class="admin-u-038">
    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq?->is_active ?? true) ? 'checked' : '' }}>
    Active
</label>
