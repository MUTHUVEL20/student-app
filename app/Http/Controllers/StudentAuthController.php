<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;

use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    
    public function loginPage () {

        return view('login');
    }


    public function login (Request $request) {


        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        $student = Student::where('email', $request->email)->first();


        if(!$student || !Hash::check($request->password, $student->password)) {

            return back()->with('error','invalid mail or password');

        }


        session(['student_id' => $student->id]);


        return redirect()->route('dashboard');

    }
}
