<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class StudentSubjectController extends Controller
{
    public function addSubject(Subject $subject)
    {
        // Get the authenticated student (you may need to adjust how you fetch the student based on your authentication setup)
        $student = auth()->user(); // Assuming you are using Laravel's default authentication and the student is logged in

        // Attach the subject to the student
        $student->subjects()->attach($subject);

        // You can also return a response or redirect to another page after adding the subject
        return redirect()->back()->with('success', 'Subject added successfully!');
    }
}
