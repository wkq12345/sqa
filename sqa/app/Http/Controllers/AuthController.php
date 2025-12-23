<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Admin;

class AuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Show register form
    public function showRegister()
    {
        return view('auth.register');
    }

    private function generateAdminId()
    {
        // Get the last admin ID from DB
        $lastAdmin = Admin::orderBy('id', 'desc')->first();

        // Default number
        $number = 1;

        if ($lastAdmin && $lastAdmin->admin_id) {
            // Extract the number from admin_id, e.g. AD0005 -> 5
            $number = intval(substr($lastAdmin->admin_id, 2)) + 1;
        }

        // Return formatted ID, e.g. AD0006
        return 'AD' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    private function generateStaffId()
    {
        // Get the last staff ID from DB
        $lastStaff = Staff::orderBy('id', 'desc')->first();

        // Default number
        $number = 1;

        if ($lastStaff && $lastStaff->staff_id) {
            // Extract the number from staff_id, e.g. ST0005 -> 5
            $number = intval(substr($lastStaff->staff_id, 2)) + 1;
        }

        // Return formatted ID, e.g. ST0006
        return 'ST' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    private function generateStudentId()
    {
        $lastStudent = Student::orderBy('id', 'desc')->first();

        $number = 1;

        if ($lastStudent && $lastStudent->student_id) {
            $number = intval(substr($lastStudent->student_id, 3)) + 1;
        }

        // Return formatted ID, e.g. STU0006
        return 'STU' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }


    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z]).{8,}$/', 'confirmed'],
            'role_id' => 'required|in:1,2,3',
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must include at least one uppercase letter.',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        // Create corresponding profile based on role
        if ($user->role_id == 3) {
            Student::create([
                'user_id' => $user->id,
                'role_id' => $user->role_id,
                'student_id' => $this->generateStudentId(),
            ]);
        } elseif ($user->role_id == 2) {
            Staff::create([
                'user_id' => $user->id,
                'role_id' => $user->role_id,
                'staff_id' => $this->generateStaffId(),
            ]);
        } elseif ($user->role_id == 1) {
            Admin::create([
                'user_id' => $user->id,
                'role_id' => $user->role_id,
                'admin_id' => $this->generateAdminId(),
            ]);
        }

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }


    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Redirect based on role
            if ($user->role->name === 'student') {
                return redirect()->route('student.dashboard');
            } elseif ($user->role->name === 'staff') {
                return redirect()->route('staff.dashboard');
            } elseif ($user->role->name === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home'); // default fallback
            }
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
