@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Add New Setting</h2>
@endsection

@section('content')
    <div class="card admin-u-067">
        <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="logo">Company Logo</label>
                <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                @error('logo') <small class="admin-u-021">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="email">Company Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                @error('email') <small class="admin-u-021">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="phone">Company Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                @error('phone') <small class="admin-u-021">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="whatsapp_number">WhatsApp Number</label>
                <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control" placeholder="+971 50 000 0000" value="{{ old('whatsapp_number') }}">
                @error('whatsapp_number') <small class="admin-u-021">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="quote_link">Quote Button Link</label>
                <input type="text" name="quote_link" id="quote_link" class="form-control" placeholder="/contact or https://example.com/quote" value="{{ old('quote_link') }}">
                @error('quote_link') <small class="admin-u-021">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="fax">Company Fax</label>
                <input type="text" name="fax" id="fax" class="form-control" value="{{ old('fax') }}">
                @error('fax') <small class="admin-u-021">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="address">Company Address</label>
                <textarea name="address" id="address" class="form-control" rows="4" placeholder="Your location, street, and office details">{{ old('address') }}</textarea>
                @error('address') <small class="admin-u-021">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="instagram">Instagram Link</label>
                <input type="url" name="instagram" id="instagram" class="form-control" placeholder="https://instagram.com/yourprofile" value="{{ old('instagram') }}">
            </div>

            <div class="form-group">
                <label for="facebook">Facebook Link</label>
                <input type="url" name="facebook" id="facebook" class="form-control" placeholder="https://facebook.com/yourpage" value="{{ old('facebook') }}">
            </div>

            <div class="form-group">
                <label for="youtube">YouTube Link</label>
                <input type="url" name="youtube" id="youtube" class="form-control" placeholder="https://youtube.com/@yourchannel" value="{{ old('youtube') }}">
            </div>

            <div class="form-group">
                <label for="tiktok">TikTok Link</label>
                <input type="url" name="tiktok" id="tiktok" class="form-control" placeholder="https://tiktok.com/@yourprofile" value="{{ old('tiktok') }}">
            </div>

            <div class="form-group">
                <label for="linkedin">LinkedIn Link</label>
                <input type="url" name="linkedin" id="linkedin" class="form-control" placeholder="https://linkedin.com/company/yourcompany" value="{{ old('linkedin') }}">
            </div>

            <div class="form-group">
                <label for="pinterest">Pinterest Link</label>
                <input type="url" name="pinterest" id="pinterest" class="form-control" placeholder="https://pinterest.com/yourprofile" value="{{ old('pinterest') }}">
            </div>

            <div class="admin-u-044">
                <button type="submit" class="btn btn-primary">Save Settings</button>
                <a href="{{ route('settings.index') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>
    </div>
@endsection
