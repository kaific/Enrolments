<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\Doctor;
use App\Patient;
use App\Enrolment;
use App\Http\Controllers\Controller;

class EnrolmentController extends Controller
{
    public function index()
    {
        $enrolments = Enrolment::all()->load(['course', 'student']);

        return $enrolments;
    }

    public function store(Request $request)
    {
        $course_id = $request->input('course_id', 0);
        $student_id = $request->input('student_id', 0);

        $rules = [
            'date' => 'required|date',
            'time' => 'required|regex:/[0-9]{2}:[0-9]{2}/',
            'status' => 'required|string|in:registered,attending,deferred,withdrawn',
            'course_id' => 'required|exists:courses,id|unique:enrolments,course_id,NULL,id,student_id,' . $student_id,
            'student_id' => 'required|exists:students,id|unique:enrolments,student_id,NULL,id,course_id,' . $course_id
        ];
        $messages = [
            'course_id.unique' => 'Student is already enrolled on course',
            'student_id.unique' => 'Student is already enrolled on course'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $enrolment = new Enrolment();
        $enrolment->date = $request->input('date');
        $enrolment->time = $request->input('time');
        $enrolment->status = $request->input('status');
        $enrolment->course_id = $request->input('course_id');
        $enrolment->student_id = $request->input('student_id');
        $enrolment->save();

        return $enrolment;
    }

    public function show($id)
    {
        $enrolment = Enrolment::findOrFail($id);

        $enrolment->load(['course', 'student']);

        return $enrolment;
    }

    public function update(Request $request, $id)
    {
        $course_id = $request->input('course_id', 0);
        $student_id = $request->input('student_id', 0);

        $rules = [
            'date' => 'required|date',
            'time' => 'required|regex:/[0-9]{2}:[0-9]{2}/',
            'status' => 'required|string|in:registered,attending,deferred,withdrawn',
            'course_id' => 'required|exists:courses,id|unique:enrolments,course_id,'.$id.',id,student_id,' . $student_id,
            'student_id' => 'required|exists:students,id|unique:enrolments,student_id,'.$id.',id,course_id,' . $course_id
        ];
        $messages = [
            'course_id.unique' => 'Student is already enrolled on course',
            'student_id.unique' => 'Student is already enrolled on course'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $enrolment = Enrolment::findOrFail($id);
        $enrolment->date = $request->input('date');
        $enrolment->time = $request->input('time');
        $enrolment->status = $request->input('status');
        $enrolment->course_id = $request->input('course_id');
        $enrolment->student_id = $request->input('student_id');
        $enrolment->save();

        return $enrolment;
    }

    public function destroy(Request $request, $id)
    {
        $enrolment = Enrolment::findOrFail($id);

        $enrolment->delete();

        return response()->json(['message' => 'Successfully deleted'], 200);
    }
}
