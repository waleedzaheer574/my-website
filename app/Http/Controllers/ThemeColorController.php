<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;

class ThemeColorController extends Controller
{
    public function edit()
    {
        $setting = CompanySetting::latest()->first() ?? CompanySetting::create();

        $presets = [
            [
                'name' => 'Default Green',
                'primary' => '#38BDF8',
                'secondary' => '#22C55E',
                'dark' => '#020617',
            ],
            [
                'name' => 'Blue Cyan',
                'primary' => '#2563eb',
                'secondary' => '#06b6d4',
                'dark' => '#111827',
            ],
            [
                'name' => 'Purple Pink',
                'primary' => '#7c3aed',
                'secondary' => '#ec4899',
                'dark' => '#1f1437',
            ],
            [
                'name' => 'Orange Amber',
                'primary' => '#f97316',
                'secondary' => '#facc15',
                'dark' => '#1f2937',
            ],
            [
                'name' => 'Teal Mint',
                'primary' => '#0f766e',
                'secondary' => '#34d399',
                'dark' => '#10201d',
            ],
            [
                'name' => 'Red Rose',
                'primary' => '#dc2626',
                'secondary' => '#fb7185',
                'dark' => '#241313',
            ],
        ];

        return view('dashboard.theme-colors.edit', compact('setting', 'presets'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'theme_primary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_secondary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'theme_dark_color' => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ], [
            '*.regex' => 'Please enter a valid color code like #38BDF8.',
        ]);

        $validated['theme_dark_color'] = $validated['theme_dark_color'] ?: '#020617';

        $setting = CompanySetting::latest()->first() ?? CompanySetting::create();
        $setting->update($validated);

        return redirect()->route('theme-colors.edit')->with('success', 'Theme colors updated successfully.');
    }

    public function reset()
    {
        $setting = CompanySetting::latest()->first() ?? CompanySetting::create();

        $setting->update([
            'theme_primary_color' => '#38BDF8',
            'theme_secondary_color' => '#22C55E',
            'theme_dark_color' => '#020617',
        ]);

        return redirect()->route('theme-colors.edit')->with('success', 'Theme colors reset to default.');
    }
}
