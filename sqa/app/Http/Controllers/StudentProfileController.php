<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentProfileController extends Controller
{
    public function index()
    {
        $student = Student::where('user_id', Auth::id())->with('user', 'role')->firstOrFail();
        return view('student.profile', compact('student'));
    }

    public function update(Request $request)
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'identification_number' => 'nullable|string|max:50|unique:students,identification_number,' . $student->id,
        ]);

        $student->update($request->only(['name', 'gender', 'phone', 'address', 'identification_number']));

        return back()->with('success', 'Profile updated successfully!');
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate(['photo' => 'required|image|mimes:jpg,jpeg,png|max:2048']);

        $student = Student::where('user_id', Auth::id())->firstOrFail();

        if ($student->photo && Storage::exists($student->photo)) {
            Storage::delete($student->photo);
        }

        $path = $request->file('photo')->store('profile_photos', 'public');
        $student->photo = $path;
        $student->save();

        return back()->with('success', 'Profile photo updated!');
    }
}
