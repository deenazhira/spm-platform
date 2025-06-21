<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function show(Topic $topic)
    {
        // You can implement additional logic if needed
        return view('topics.show', compact('topic'));
    }
}
