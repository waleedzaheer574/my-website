@php($isEdit = isset($service) && $service)

<div class="form-group">
    <label for="icon">Service Icon</label>
    <input type="file" name="icon" id="icon" class="form-control" accept=".jpg,.jpeg,.png,.webp,.svg,image/jpeg,image/png,image/webp,image/svg+xml">
    @if($isEdit && $service->icon)
        <img class="admin-u-092" src="{{ asset($service->icon) }}" alt="{{ $service->localized('service_title') }}">
    @endif
    <small class="admin-u-048">Optional. Upload JPG, PNG, WEBP, or SVG icon.</small>
    @error('icon') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="service_title">Service Title</label>
    <input type="text" name="service_title" id="service_title" class="form-control" required value="{{ old('service_title', $service->service_title ?? '') }}">
    @error('service_title') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="service_description">Service Description</label>
    <textarea name="service_description" id="service_description" class="form-control" rows="5" required>{{ old('service_description', $service->service_description ?? '') }}</textarea>
    @error('service_description') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="service_title_ar">Service Title (Arabic)</label>
    <input type="text" name="service_title_ar" id="service_title_ar" class="form-control" dir="rtl" lang="ar" value="{{ old('service_title_ar', $service->service_title_ar ?? '') }}">
    @error('service_title_ar') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="service_description_ar">Service Description (Arabic)</label>
    <textarea name="service_description_ar" id="service_description_ar" class="form-control" dir="rtl" lang="ar" rows="5">{{ old('service_description_ar', $service->service_description_ar ?? '') }}</textarea>
    @error('service_description_ar') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="order">Display Order</label>
    <input type="number" name="order" id="order" class="form-control" value="{{ old('order', $service->order ?? 0) }}" min="0">
    @error('order') <small class="admin-u-021">{{ $message }}</small> @enderror
</div>

<div class="admin-u-044">
    <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update Service' : 'Save Service' }}</button>
    <a href="{{ route('services.index') }}" class="btn admin-u-005">Cancel</a>
</div>
