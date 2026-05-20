<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\AgencyProject;
use App\Models\AgencySubscription;
use App\Models\OfferOrder;
use App\Models\ServiceRequest;
use App\Models\QuoteRequest;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('dashboard.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function userEdit(Request $request)
    {
        $user = $request->user();

        return view('user.profile', [
            'user' => $user,
            'serviceRequestsCount' => ServiceRequest::where('user_id', $user->id)->count(),
            'quoteRequestsCount' => QuoteRequest::where('user_id', $user->id)->count(),
            'ordersCount' => OfferOrder::where('user_id', $user->id)->count(),
            'projectsCount' => AgencyProject::where('user_id', $user->id)->count(),
            'subscriptionsCount' => AgencySubscription::where('user_id', $user->id)->count(),
            'unreadNotificationsCount' => $user->unreadNotifications()->count(),
            'headerNotifications' => $user->notifications()->latest()->take(8)->get(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
        ]);

        $user->update($data);

        return back()->with('success', 'Profile details updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}
