<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->get();
        return view('courses.courselist', compact('courses'));
    }

    public function create()
    {
        return view('courses.createcourse');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_title' => ['required', 'string', 'max:255'],
            'course_code'  => ['required', 'string', 'max:50', Rule::unique('courses', 'course_code')],
            'description'  => ['nullable', 'string'],
            'category'     => ['nullable', 'string', 'max:100'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')
                ->store('course_images', 'public');
        }

        Course::create([
            'course_title' => $validated['course_title'],
            'course_code'  => $validated['course_code'],
            'description'  => $validated['description'] ?? null,
            'category'     => $validated['category'] ?? null,
            'image_path'   => $validated['image_path'] ?? null,
        ]);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        return view('courses.editcourse', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_title' => ['required', 'string', 'max:255'],
            'course_code'  => [
                'required',
                'string',
                'max:50',
                Rule::unique('courses', 'course_code')->ignore($course->course_id, 'course_id')
            ],
            'description'  => ['nullable', 'string'],
            'category'     => ['nullable', 'string', 'max:100'],
            'image'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_image' => ['nullable', 'in:1'],
        ]);

        if (($validated['remove_image'] ?? null) === '1' && $course->image_path) {
            Storage::disk('public')->delete($course->image_path);
            $course->image_path = null;
        }

        if ($request->hasFile('image')) {
            if ($course->image_path) {
                Storage::disk('public')->delete($course->image_path);
            }
            $course->image_path = $request->file('image')
                ->store('course_images', 'public');
        }

        $course->update([
            'course_title' => $validated['course_title'],
            'course_code'  => $validated['course_code'],
            'description'  => $validated['description'] ?? null,
            'category'     => $validated['category'] ?? null,
        ]);

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        if ($course->image_path) {
            Storage::disk('public')->delete($course->image_path);
        }

        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
