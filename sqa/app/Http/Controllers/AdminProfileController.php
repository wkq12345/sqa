<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    public function index()
    {
        $admin = Admin::where('user_id', Auth::id())->with('user', 'role')->firstOrFail();
        return view('admin.profile', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = Admin::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'identification_number' => 'nullable|string|max:50|unique:admins,identification_number,' . $admin->id,
        ]);

        $admin->update($request->only(['name', 'gender', 'phone', 'address', 'identification_number']));

        return back()->with('success', 'Profile updated successfully!');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate(['photo' => 'required|image|mimes:jpg,jpeg,png|max:2048']);

        $admin = Admin::where('user_id', Auth::id())->firstOrFail();

        if ($admin->photo && Storage::disk('public')->exists($admin->photo)) {
            Storage::disk('public')->delete($admin->photo);
        }

        $path = $request->file('photo')->store('profile_photos', 'public');
        $admin->photo = $path;
        $admin->save();

        return back()->with('success', 'Profile photo updated!');
    }
}
