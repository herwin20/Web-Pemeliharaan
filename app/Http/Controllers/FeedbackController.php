<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    #code..
    public function index()
    {
        return view('feedback.feedback');
    }
}
