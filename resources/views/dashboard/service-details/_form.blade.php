@php($isEdit = isset($serviceDetail) && $serviceDetail)

<div class="form-group">
    <label for="service_id">Linked Service</label>
    <select name="service_id" id="service_id" class="form-control">
        <option value="">Not linked</option>
        @foreach($services as $service)
            <option value="{{ $service->id }}" @selected((string) old('service_id', $serviceDetail->service_id ?? '') === (string) $service->id)>
                {{ $service->service_title }}
            </option>
        @endforeach
    </select>
    @error('service_id') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

@foreach([
    'slug' => 'Slug',
    'title_prefix' => 'Title Prefix',
    'title_highlight' => 'Title Highlight',
    'process_heading' => 'Process Heading',
    'process_one_title' => 'Process One Title',
    'process_two_title' => 'Process Two Title',
    'process_three_title' => 'Process Three Title',
] as $field => $label)
    <div class="form-group">
        <label for="{{ $field }}">{{ $label }}</label>
        <input type="text" name="{{ $field }}" id="{{ $field }}" class="form-control" value="{{ old($field, $serviceDetail->{$field} ?? '') }}" @if(in_array($field, ['title_prefix', 'title_highlight'])) required @endif>
        @error($field) <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
@endforeach

@foreach([
    'description' => 'Description',
    'process_one_text' => 'Process One Text',
    'process_two_text' => 'Process Two Text',
    'process_three_text' => 'Process Three Text',
] as $field => $label)
    <div class="form-group">
        <label for="{{ $field }}">{{ $label }}</label>
        <textarea name="{{ $field }}" id="{{ $field }}" class="form-control" rows="4" @if($field === 'description') required @endif>{{ old($field, $serviceDetail->{$field} ?? '') }}</textarea>
        @error($field) <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
@endforeach

<h3>Arabic Content</h3>
@foreach([
    'title_prefix_ar' => 'Title Prefix (Arabic)',
    'title_highlight_ar' => 'Title Highlight (Arabic)',
    'process_heading_ar' => 'Process Heading (Arabic)',
    'process_one_title_ar' => 'Process One Title (Arabic)',
    'process_two_title_ar' => 'Process Two Title (Arabic)',
    'process_three_title_ar' => 'Process Three Title (Arabic)',
] as $field => $label)
    <div class="form-group">
        <label for="{{ $field }}">{{ $label }}</label>
        <input type="text" name="{{ $field }}" id="{{ $field }}" class="form-control" dir="rtl" lang="ar" value="{{ old($field, $serviceDetail->{$field} ?? '') }}">
        @error($field) <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
@endforeach

@foreach([
    'description_ar' => 'Description (Arabic)',
    'process_one_text_ar' => 'Process One Text (Arabic)',
    'process_two_text_ar' => 'Process Two Text (Arabic)',
    'process_three_text_ar' => 'Process Three Text (Arabic)',
] as $field => $label)
    <div class="form-group">
        <label for="{{ $field }}">{{ $label }}</label>
        <textarea name="{{ $field }}" id="{{ $field }}" class="form-control" dir="rtl" lang="ar" rows="4">{{ old($field, $serviceDetail->{$field} ?? '') }}</textarea>
        @error($field) <small class="admin-u-021">{{ $message }}</small> @enderror
    </div>
@endforeach

<div class="form-group">
    <label for="primary_image">Primary Image</label>
    <input type="file" name="primary_image" id="primary_image" class="form-control" accept="image/*" @unless($isEdit) required @endunless>
    @if($isEdit && $serviceDetail->primary_image)
        <img class="admin-u-092" src="{{ asset($serviceDetail->primary_image) }}" alt="">
    @endif
    @error('primary_image') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="video_url">Video URL <span class="admin-u-048">(optional)</span></label>
    <input type="text" name="video_url" id="video_url" class="form-control" value="{{ old('video_url', $serviceDetail->video_url ?? '') }}" placeholder="https://www.youtube.com/watch?v=...">
    <small class="admin-u-048">Leave this empty if this service does not need a video.</small>
    @error('video_url') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="video_thumbnail">Video Thumbnail <span class="admin-u-048">(optional)</span></label>
    <input type="file" name="video_thumbnail" id="video_thumbnail" class="form-control" accept="image/*">
    @if($isEdit && $serviceDetail->video_thumbnail)
        <img class="admin-u-092" src="{{ asset($serviceDetail->video_thumbnail) }}" alt="">
    @endif
    <small class="admin-u-048">If a video URL is added, this image will be used as the preview. Otherwise the primary image will be used.</small>
    @error('video_thumbnail') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>
