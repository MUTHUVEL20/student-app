<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;

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
                          'password' => $validated['password'],
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
}
