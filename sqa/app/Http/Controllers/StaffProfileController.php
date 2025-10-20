<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;
use Illuminate\Support\Facades\Storage;

class StaffProfileController extends Controller
{
    public function index()
    {
        $staff = Staff::where('user_id', Auth::id())->with('user', 'role')->firstOrFail();
        return view('staff.profile', compact('staff'));
    }

    public function update(Request $request)
    {
        $staff = Staff::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'identification_number' => 'nullable|string|max:50|unique:staff,identification_number,' . $staff->id,
        ]);

        $staff->update($request->only(['name', 'gender', 'phone', 'address', 'identification_number']));

        return back()->with('success', 'Profile updated successfully!');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate(['photo' => 'required|image|mimes:jpg,jpeg,png|max:2048']);

        $staff = Staff::where('user_id', Auth::id())->firstOrFail();

        if ($staff->photo && Storage::exists($staff->photo)) {
            Storage::delete($staff->photo);
        }

        $path = $request->file('photo')->store('profile_photos', 'public');
        $staff->photo = $path;
        $staff->save();

        return back()->with('success', 'Profile photo updated!');
    }
}
