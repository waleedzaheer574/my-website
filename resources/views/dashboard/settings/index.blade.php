@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Company Settings</h2>
@endsection

@section('content')
    <div class="card">
        <div class="admin-u-010">
            <h3 class="admin-u-011">All Settings</h3>
            <a href="{{ route('settings.create') }}" class="btn btn-primary">Add New Setting</a>
        </div>

        <div class="admin-u-012">
            <table>
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>WhatsApp</th>
                        <th>Fax</th>
                        <th>Quote Link</th>
                        <th>Address</th>
                        <th>Social Links</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($settings as $setting)
                        <tr>
                            <td>
                                @if($setting->logo)
                                    <img class="admin-u-094" src="{{ asset('storage/' . $setting->logo) }}" alt="Logo">
                                @else
                                    <span>No Logo</span>
                                @endif
                            </td>
                            <td>{{ $setting->email }}</td>
                            <td>{{ $setting->phone }}</td>
                            <td>{{ $setting->whatsapp_number ?: __('website.common.not_available') }}</td>
                            <td>{{ $setting->fax ?: __('website.common.not_available') }}</td>
                            <td>{{ $setting->quote_link ?: url('/contact') }}</td>
                            <td class="admin-u-069">{{ $setting->address ?: __('website.common.not_available') }}</td>
                            <td>
                                <div class="admin-u-013">
                                    @if($setting->facebook) <span title="Facebook">FB</span> @endif
                                    @if($setting->instagram) <span title="Instagram">IG</span> @endif
                                    @if($setting->pinterest) <span title="Pinterest">PN</span> @endif
                                    @if($setting->youtube) <span title="YouTube">YT</span> @endif
                                    @if($setting->tiktok) <span title="TikTok">TT</span> @endif
                                    @if($setting->linkedin) <span title="LinkedIn">IN</span> @endif
                                </div>
                            </td>
                            <td>
                                <div class="admin-u-031">
                                    <a class="admin-u-073" href="{{ route('settings.edit', $setting->id) }}">Edit</a>
                                    <form action="{{ route('settings.destroy', $setting->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-u-014" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-u-015" colspan="9">No settings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
