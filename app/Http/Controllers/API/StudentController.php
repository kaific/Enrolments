<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\Student;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all()->load('enrolments.course');

        return $students;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'address' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:50|unique:students'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $student = new Student();
        $student->name = $request->input('name');
        $student->address = $request->input('address');
        $student->phone = $request->input('phone');
        $student->email = $request->input('email');
        $student->save();

        return $student;
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);

        $student->load('enrolments.course');

        return $student;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'address' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:50|unique:students,id,' . $id
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $student = Student::find($id);
        $student->name = $request->input('name');
        $student->address = $request->input('address');
        $student->phone = $request->input('phone');
        $student->email = $request->input('email');
        $student->save();

        return $student;
    }

    public function destroy(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        if ($student->enrolments->count() == 0) {
            $student->delete();
            return response()->json(['message' => 'Successfully deleted'], 200);
        }
        else {
            return response()->json(['message' => 'Student not deleted'], 422);
        }
    }
}
