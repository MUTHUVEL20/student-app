<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;

class StudentCourseController extends Controller
{
    

    public function assignCourses (Request $request,$studentId) {

        $student = Student::findOrFail($studentId);


        $request->validate([

            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id'
        ]);


        // $student-> course()->syncWithoutDetaching($request->courses);

          $student-> course()->syncWithoutDetaching($request->courses);

        //   $student->course()->toggle($request->courses);



        return  response()->json(['success' => true,
                                   'message' => 'Courses attached successfully']);

        
    }

    public function removeCourse ($studentId,$courseId) {

           $student = Student::findOrFail($studentId);


           $student-> course()-> detach($courseId);


           return response()-> json(['success' => true,
                                      'message' => 'course removed successfully']);


    }


    public function listCourse ($studentId) {

        $student = Student::with('course')-> findOrFail ($studentId);

        return $student->course;
    }
}
