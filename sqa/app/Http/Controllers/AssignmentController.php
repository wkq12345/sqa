<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
{
    // Interface 1: List all courses
    public function assignments()
    {
        // Get all courses from database
        $courses = Course::all();
        
        return view('assignments.assignments', compact('courses'));
    }

    // Interface 2: List assignments for a specific course
  public function showCourseAssignments($courseId)
    {
        // Find the course by ID
        $course = Course::findOrFail($courseId);
        
        // Get all assignments for this course, ordered by newest first
        $assignments = Assignment::where('course_id', $courseId)
                                 ->orderBy('created_at', 'desc')
                                 ->get();
        
        return view('assignments.course_assignments', compact('course', 'assignments'));
    }

    // Interface 3: Show create form
      public function create($courseId)
    {
        // Find the course
        $course = Course::findOrFail($courseId);
        
        return view('assignments.create', compact('course'));
    }

    // Store new assignment
     public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'due_date' => 'required|date|after_or_equal:today',
            'due_time' => 'required|date_format:H:i',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $filePath = null;
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            $filePath = $file->storeAs('assignments', $fileName, 'public');
        }

         try {
            $assignment = Assignment::create([
                'course_id' => $request->course_id,  
                'title' => $request->title,
                'due_date' => $request->due_date,
                'due_time' => $request->due_time,
                'description' => $request->description,
                'file_path' => $filePath,
            ]);

         return redirect()->route('assignments.course', $request->course_id)
                           ->with('success', 'Assignment created successfully!');
                           
        } catch (\Exception $e) {
            // If database operation fails, delete uploaded file
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            
            return redirect()->back()
                           ->with('error', 'Failed to create assignment: ' . $e->getMessage())
                           ->withInput();
        }
    }

    // Interface 4: Show edit form
    public function edit($assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId);
        
        return view('assignments.edit', compact('assignment'));
    }

    // Update assignment
    public function update(Request $request, $assignment_id)
    {
    
        $assignment = Assignment::findOrFail($assignment_id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'due_date' => 'required|date',
            'due_time' => 'required|date_format:H:i',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

     $filePath = $assignment->file_path; // Keep existing file by default
        
        if ($request->hasFile('file')) {
            // Delete old file if it exists
            if ($assignment->file_path && Storage::disk('public')->exists($assignment->file_path)) {
                Storage::disk('public')->delete($assignment->file_path);
            }
            
            // Upload new file
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('assignments', $fileName, 'public');
        }

        try {
            $assignment->update([
                'title' => $request->title,
                'due_date' => $request->due_date,
                'due_time' => $request->due_time,
                'description' => $request->description,
                'file_path' => $filePath,
            ]);

            return redirect()->route('assignments.course', $assignment->course_id)
                           ->with('success', 'Assignment updated successfully!');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to update assignment: ' . $e->getMessage())
                           ->withInput();
        }
    }

    //Remove assignment from database
    public function destroy($assignment_id)
    {
        // Find the assignment
        $assignment = Assignment::findOrFail($assignment_id);
        
        $courseId = $assignment->course_id; // Store for redirect

        try {
            // Delete file if it exists
            if ($assignment->file_path && Storage::disk('public')->exists($assignment->file_path)) {
                Storage::disk('public')->delete($assignment->file_path);
            }

            // Delete assignment from database
            $assignment->delete();

            return redirect()->route('assignments.course', $courseId)
                           ->with('success', 'Assignment deleted successfully!');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to delete assignment: ' . $e->getMessage());
        }
    }
}