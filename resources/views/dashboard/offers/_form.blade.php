@php($isEdit = !empty($offer))

<div class="form-group">
  <label for="service_id">Linked Service</label>
  <select name="service_id" id="service_id" class="form-control">
    <option value="">No linked service</option>
    @foreach($services as $service)
      <option value="{{ $service->id }}" @selected((int) old('service_id', $offer?->service_id) === $service->id)>{{ $service->service_title }}</option>
    @endforeach
  </select>
</div>

<div class="form-group">
  <label for="title">Title</label>
  <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $offer?->title) }}" required>
</div>

<div class="form-group">
  <label for="slug">Slug</label>
  <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $offer?->slug) }}" placeholder="Auto generated if empty">
</div>

<div class="form-group">
  <label for="category">Category</label>
  <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $offer?->category) }}">
</div>

<div class="form-group">
  <label for="description">Description</label>
  <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $offer?->description) }}</textarea>
</div>

<div class="form-group">
  <label for="detail_overview">Detail Page Overview</label>
  <textarea name="detail_overview" id="detail_overview" class="form-control" rows="4">{{ old('detail_overview', $offer?->detail_overview) }}</textarea>
  <small class="admin-u-048">Shown in the offer detail overview section.</small>
</div>

<div class="form-group">
  <label for="hero_visual_title">Hero Visual Title</label>
  <input type="text" name="hero_visual_title" id="hero_visual_title" class="form-control" value="{{ old('hero_visual_title', $offer?->hero_visual_title) }}" placeholder="Super fast eCommerce experience">
</div>

<div class="form-group">
  <label for="price">Price</label>
  <input type="number" name="price" id="price" class="form-control" min="0" value="{{ old('price', $offer?->price ?? 0) }}" required>
</div>

<div class="form-group">
  <label for="currency">Currency</label>
  <input type="text" name="currency" id="currency" class="form-control" value="{{ old('currency', $offer?->currency ?? 'AED') }}" required>
</div>

<div class="form-group">
  <label for="billing_cycle">Billing</label>
  <select name="billing_cycle" id="billing_cycle" class="form-control" required>
    @foreach(['one_time' => 'One-time', 'monthly' => 'Monthly', 'yearly' => 'Yearly'] as $value => $label)
      <option value="{{ $value }}" @selected(old('billing_cycle', $offer?->billing_cycle ?? 'one_time') === $value)>{{ $label }}</option>
    @endforeach
  </select>
</div>

<div class="form-group">
  <label for="delivery_time">Delivery Time</label>
  <input type="text" name="delivery_time" id="delivery_time" class="form-control" value="{{ old('delivery_time', $offer?->delivery_time) }}">
</div>

<div class="form-group">
  <label for="features_text">Features</label>
  <textarea name="features_text" id="features_text" class="form-control" rows="6">{{ old('features_text', implode("\n", $offer?->features ?? [])) }}</textarea>
  <small class="admin-u-048">One feature per line.</small>
</div>

<div class="form-group">
  <label for="overview_items_text">Overview Cards</label>
  <textarea name="overview_items_text" id="overview_items_text" class="form-control" rows="5">{{ old('overview_items_text', implode("\n", $offer?->overview_items ?? [])) }}</textarea>
  <small class="admin-u-048">One card per line. Example: Modern & Responsive Design</small>
</div>

<div class="form-group">
  <label for="detail_features_text">Detail Features</label>
  <textarea name="detail_features_text" id="detail_features_text" class="form-control" rows="7">{{ old('detail_features_text', collect($offer?->detail_features ?? [])->map(fn ($item) => ($item['title'] ?? '').' | '.($item['description'] ?? ''))->implode("\n")) }}</textarea>
  <small class="admin-u-048">One feature per line. Format: Feature title | Short description</small>
</div>

<div class="form-group">
  <label for="tech_stack_text">Technology Stack</label>
  <textarea name="tech_stack_text" id="tech_stack_text" class="form-control" rows="5">{{ old('tech_stack_text', implode("\n", $offer?->tech_stack ?? [])) }}</textarea>
  <small class="admin-u-048">One technology per line.</small>
</div>

<div class="form-group">
  <label for="delivery_timeline_text">Delivery Timeline</label>
  <textarea name="delivery_timeline_text" id="delivery_timeline_text" class="form-control" rows="6">{{ old('delivery_timeline_text', collect($offer?->delivery_timeline ?? [])->map(fn ($item) => ($item['title'] ?? '').' | '.($item['description'] ?? ''))->implode("\n")) }}</textarea>
  <small class="admin-u-048">One step per line. Format: Step title | Short description</small>
</div>

<div class="form-group">
  <label for="faqs_text">FAQs</label>
  <textarea name="faqs_text" id="faqs_text" class="form-control" rows="6">{{ old('faqs_text', collect($offer?->faqs ?? [])->map(fn ($item) => ($item['question'] ?? '').' | '.($item['answer'] ?? ''))->implode("\n")) }}</textarea>
  <small class="admin-u-048">One FAQ per line. Format: Question | Answer</small>
</div>

<div class="form-group">
  <label for="why_choose_text">Why Choose Us</label>
  <textarea name="why_choose_text" id="why_choose_text" class="form-control" rows="5">{{ old('why_choose_text', implode("\n", $offer?->why_choose ?? [])) }}</textarea>
  <small class="admin-u-048">One reason per line.</small>
</div>

<div class="form-group">
  <label for="sort_order">Sort Order</label>
  <input type="number" name="sort_order" id="sort_order" class="form-control" min="0" value="{{ old('sort_order', $offer?->sort_order ?? 0) }}">
</div>

<div class="form-group">
  <label><input type="checkbox" name="is_popular" value="1" @checked(old('is_popular', $offer?->is_popular))> Popular</label>
  <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $offer?->is_active ?? true))> Active</label>
</div>

<div class="admin-u-044">
  <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update Offer' : 'Save Offer' }}</button>
  <a href="{{ route('offers.admin.index') }}" class="btn admin-u-005">Cancel</a>
</div>
