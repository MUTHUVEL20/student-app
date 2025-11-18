<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;


use Illuminate\Support\Facades\Gate;

class StudentController extends Controller
{
    
    public function savestudent (Request $request) {

    $validated =  $request->validate([
            'name' => 'required||max:100',
            'email' => 'required|email|max:250',
            'password' => 'required|max:20',
            'phone'  => 'nullable|max:15'

          ]);


          $student = Student::create([
                          'name' => $validated['name'],
                          'email' => $validated['email'],
                          'password' =>  bcrypt($validated['password']),
                          'phone' => $validated['phone']
                        ]);


                        return response()->json([
                            'success' => true,
                            'message' => 'student added successfully'
                        ]);


    }


    public function dashboard () {

        return view('dashboard');
    }


    public function destroy ($studentid) {


       $student = Student::find($studentid);

        if (!$student) {
        return response()->json(['success' => false, 'message' => 'Student not found'], 404);
       }

    if(auth()->user()->cannot('delete',$student)) {

        return response()->json(['success' => false, 'message' => 'You are unauthorized user'],403);
    }


    $student->delete();

      return response()->json([
        'success' => true,
        'student' => $student

        
    ]);



    }
}
