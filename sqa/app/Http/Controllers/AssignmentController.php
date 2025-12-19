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
    public function index()
    {
        // Get all courses from database
        $courses = Course::all();
        
        return view('assignment.assignments', compact('courses'));
    }

    // Interface 2: List assignments for a specific course
  public function list($course_id)
    {
        // Find the course by ID
        $course = Course::findOrFail($course_id);
        
        // Get all assignments for this course, ordered by newest first
        $assignments = Assignment::where('course_id', $course_id)
                                 ->orderBy('created_at', 'desc')
                                 ->get();
        
        return view('assignment.list', compact('course', 'assignments'));
    }

    // Interface 3: Show create form
      public function create($course_id)
    {
        // Find the course
         $course = Course::where('course_id', $course_id)->firstOrFail();
        
        return view('assignment.form', compact('course'));
    }

    // Store new assignment
     public function store(Request $request)
    {
       

       $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,course_id',
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

         return redirect()->route('assignment.list', $request->course_id)
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
    public function edit($assignment_id)
    {
        $assignment = Assignment::findOrFail($assignment_id);
        return view('assignment.edit', compact('assignment'));
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

            return redirect()->route('assignment.list', $assignment->course_id)
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

            return redirect()->route('assignment.list', $courseId)
                           ->with('success', 'Assignment deleted successfully!');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Failed to delete assignment: ' . $e->getMessage());
        }
    }
}