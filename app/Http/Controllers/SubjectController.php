<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Topic;
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
}
