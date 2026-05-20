@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Theme Colors</h2>
@endsection

@section('content')
    <div class="card admin-u-067">
        <form action="{{ route('theme-colors.update') }}" method="POST" class="theme-color-form">
            @csrf
            @method('PUT')

            <div class="theme-color-preview" id="theme-preview">
                <div>
                    <span class="theme-preview-label">Live Preview</span>
                    <h3>Website Color Scheme</h3>
                </div>
                <a href="{{ url('/') }}" target="_blank" rel="noopener" class="btn btn-primary">Open Website</a>
            </div>

            <div class="theme-preset-grid">
                @foreach($presets as $preset)
                    @php
                        $currentPrimary = old('theme_primary_color', $setting->theme_primary_color ?: '#38BDF8');
                        $currentSecondary = old('theme_secondary_color', $setting->theme_secondary_color ?: '#0284C7');
                        $currentDark = old('theme_dark_color', $setting->theme_dark_color ?: '#020617');
                        $isActivePreset = strtolower($currentPrimary) === strtolower($preset['primary'])
                            && strtolower($currentSecondary) === strtolower($preset['secondary'])
                            && strtolower($currentDark) === strtolower($preset['dark']);
                    @endphp
                    <button
                        type="button"
                        class="theme-preset {{ $isActivePreset ? 'is-active' : '' }}"
                        data-primary="{{ $preset['primary'] }}"
                        data-secondary="{{ $preset['secondary'] }}"
                        data-dark="{{ $preset['dark'] }}"
                    >
                        <span class="theme-preset-swatches">
                            <span style="background: {{ $preset['primary'] }}"></span>
                            <span style="background: {{ $preset['secondary'] }}"></span>
                            <span style="background: {{ $preset['dark'] }}"></span>
                        </span>
                        <span>{{ $preset['name'] }}</span>
                    </button>
                @endforeach
            </div>

            <div class="theme-color-grid">
                <div class="form-group">
                    <label for="theme_primary_color">Primary Color <span class="theme-required">*</span></label>
                    <div class="theme-color-input">
                        <input type="color" id="theme_primary_color_picker" value="{{ old('theme_primary_color', $setting->theme_primary_color ?: '#38BDF8') }}">
                        <input type="text" name="theme_primary_color" id="theme_primary_color" class="form-control" value="{{ old('theme_primary_color', $setting->theme_primary_color ?: '#38BDF8') }}" placeholder="#38BDF8" maxlength="7">
                    </div>
                    @error('theme_primary_color') <small class="admin-u-021">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="theme_secondary_color">Secondary Color <span class="theme-required">*</span></label>
                    <div class="theme-color-input">
                        <input type="color" id="theme_secondary_color_picker" value="{{ old('theme_secondary_color', $setting->theme_secondary_color ?: '#0284C7') }}">
                        <input type="text" name="theme_secondary_color" id="theme_secondary_color" class="form-control" value="{{ old('theme_secondary_color', $setting->theme_secondary_color ?: '#0284C7') }}" placeholder="#0284C7" maxlength="7">
                    </div>
                    @error('theme_secondary_color') <small class="admin-u-021">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label for="theme_dark_color">Dark Color <span class="theme-optional">Optional</span></label>
                    <div class="theme-color-input">
                        <input type="color" id="theme_dark_color_picker" value="{{ old('theme_dark_color', $setting->theme_dark_color ?: '#020617') }}">
                        <input type="text" name="theme_dark_color" id="theme_dark_color" class="form-control" value="{{ old('theme_dark_color', $setting->theme_dark_color ?: '#020617') }}" placeholder="#020617" maxlength="7">
                    </div>
                    @error('theme_dark_color') <small class="admin-u-021">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="admin-u-044">
                <button type="submit" class="btn btn-primary">Save Theme Colors</button>
                <a href="{{ route('dashboard') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>

        <form action="{{ route('theme-colors.reset') }}" method="POST" class="theme-reset-form" onsubmit="return confirm('Reset theme colors to the default scheme?')">
            @csrf
            <button type="submit" class="btn theme-reset-button">Reset to Default</button>
        </form>
    </div>

    <script>
        const colorFields = [
            ['theme_primary_color', 'theme_primary_color_picker'],
            ['theme_secondary_color', 'theme_secondary_color_picker'],
            ['theme_dark_color', 'theme_dark_color_picker'],
        ];

        const normalizeColor = (value) => {
            const color = value.trim();
            return color.startsWith('#') ? color : `#${color}`;
        };

        const updatePreview = () => {
            const primary = document.getElementById('theme_primary_color').value;
            const secondary = document.getElementById('theme_secondary_color').value;
            const dark = document.getElementById('theme_dark_color').value || '#020617';
            const preview = document.getElementById('theme-preview');

            preview.style.setProperty('--preview-primary', primary);
            preview.style.setProperty('--preview-secondary', secondary);
            preview.style.setProperty('--preview-dark', dark);

            document.querySelectorAll('.theme-preset').forEach((button) => {
                const isActive = button.dataset.primary.toLowerCase() === primary.toLowerCase()
                    && button.dataset.secondary.toLowerCase() === secondary.toLowerCase()
                    && button.dataset.dark.toLowerCase() === dark.toLowerCase();

                button.classList.toggle('is-active', isActive);
            });
        };

        colorFields.forEach(([textId, pickerId]) => {
            const text = document.getElementById(textId);
            const picker = document.getElementById(pickerId);

            picker.addEventListener('input', () => {
                text.value = picker.value;
                updatePreview();
            });

            text.addEventListener('input', () => {
                const color = normalizeColor(text.value);

                if (/^#[0-9A-Fa-f]{6}$/.test(color)) {
                    text.value = color;
                    picker.value = color;
                    updatePreview();
                }
            });
        });

        document.querySelectorAll('.theme-preset').forEach((button) => {
            button.addEventListener('click', () => {
                document.getElementById('theme_primary_color').value = button.dataset.primary;
                document.getElementById('theme_secondary_color').value = button.dataset.secondary;
                document.getElementById('theme_dark_color').value = button.dataset.dark;
                document.getElementById('theme_primary_color_picker').value = button.dataset.primary;
                document.getElementById('theme_secondary_color_picker').value = button.dataset.secondary;
                document.getElementById('theme_dark_color_picker').value = button.dataset.dark;
                updatePreview();
            });
        });

        updatePreview();
    </script>
@endsection
