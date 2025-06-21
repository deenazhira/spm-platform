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
        // Validate the incoming request data
        $request->validate([
            'username' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'topic_number' => 'required|integer',
        ]);

        // Create a new subject
        $subject = new Subject();
        $subject->username = $request->username;
        $subject->code = $request->code;
        $subject->title = $request->title;
        $subject->topic_number = $request->topic_number;
        $subject->save();

        // Redirect back or to another page
        return redirect()->route('subjects.index')->with('success', 'Subject added successfully!');
    }
}
