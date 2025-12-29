<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Student;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display all courses for enrollment
     */
    public function index()
    {
        $courses = Course::orderBy('course_title')->get();
        return view('module.enroll', compact('courses'));
    }

    /**
     * Show enrolled students for a specific course
     */
    public function show($courseId)
    {
        $course = Course::where('course_id', $courseId)->firstOrFail();

        $modules = Module::with('student')
            ->where('course_id', $courseId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('module.view', compact('course', 'modules'));
    }

    /**
     * Show form to add students
     */
    public function create($courseId)
    {
        $course = Course::where('course_id', $courseId)->firstOrFail();
        $students = Student::orderBy('name')->get();

        return view('module.add', compact('course', 'students'));
    }

    /**
     * Store new student enrollment
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|array',
            'course_id'  => 'required|exists:courses,course_id',
        ]);

        foreach ($request->student_id as $studentId) {

            $exists = Module::where('student_id', $studentId)
                            ->where('course_id', $request->course_id)
                            ->exists();

            if (!$exists) {
                $student = Student::findOrFail($studentId);

                Module::create([
                    'student_id' => $student->id,
                    'name'       => $student->name,
                    'course_id'  => $request->course_id,
                    'status'     => 'active',
                ]);
            }
        }

        return redirect()
            ->route('module.show', $request->course_id)
            ->with('success', 'Students successfully added to the module.');
    }

    /**
     * Update enrollment status
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,completed,withdrawn',
        ]);

        $module = Module::findOrFail($id);
        $module->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Student status updated successfully.');
    }

    /**
     * Remove student from course
     */
    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $courseId = $module->course_id;

        $module->delete();

        return redirect()
            ->route('module.show', $courseId)
            ->with('success', 'Student removed from the module.');
    }
}
