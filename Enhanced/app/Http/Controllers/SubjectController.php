<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return view('subjects.index', compact('subjects'));
    }

    public function show(Subject $subject)
    {
        $topics = $subject->topics;
        return view('subjects.show', compact('subject', 'topics'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:subjects,code',
            'title' => 'required|string|max:255',
            'topic_number' => 'required|integer',
            'syllabus' => 'required|file|mimes:pdf|max:2048', // ✅ validate PDF only, max 2MB
        ]);

        // Store the uploaded file in storage/app/syllabi
        $syllabusPath = $request->file('syllabus')->store('syllabi');

        // Create and save the new subject
        $subject = new Subject;
        $subject->username = $validated['username'];
        $subject->code = $validated['code'];
        $subject->title = $validated['title'];
        $subject->topic_number = $validated['topic_number'];
        $subject->syllabus_path = $syllabusPath; // ✅ save path to DB
        $subject->save();

        // Redirect with success message
        return redirect()->route('subjects.index')->with('success', 'Subject added successfully!');
    }
}
