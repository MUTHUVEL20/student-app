<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Course;

class CourseController extends Controller
{
    

    public function index () {


        return Course::with('student')->get();
    }


    public function store (Request $request) {


        $course = Course::create($request->only('title','code'));

        return response()->json($course,401);
    }

    public function show ($id) {


        return Course::with('student')->findOrFail($id);
    }
}
