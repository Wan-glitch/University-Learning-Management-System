<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $title = "Courses";

        return view('courses.index', compact('title'));
    }

    public function programmingFundamentals()
    {
        $title = "Programming Fundamentals";
        return view('courses.programming-fundamentals' , compact('title'));
    }

    public function machineLearning()
    {
        return view('courses.machine-learning');
    }

    public function webDevelopment()
    {
        return view('courses.web-development');
    }
}
