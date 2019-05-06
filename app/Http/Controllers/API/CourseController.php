<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Validator;
use App\Course;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all()->load('enrolments.student');

        return $courses;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:50',
            'code' => 'required|string|max:5',
            'description' => 'required|string',
            'points' => 'required|integer|min:100,max:600',
            'level' => 'required|integer|min:7,max:10'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $course = new Course();
        $course->title = $request->input('title');
        $course->code = $request->input('code');
        $course->description = $request->input('description');
        $course->points = $request->input('points');
        $course->level = $request->input('level');
        $course->save();

        return $course;
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);

        $course->load('enrolments.student');

        return $course;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:50',
            'code' => 'required|string|max:5',
            'description' => 'required|string',
            'points' => 'required|integer|min:100,max:600',
            'level' => 'required|integer|min:7,max:10'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $course = Course::findOrFail($id);
        $course->title = $request->input('title');
        $course->code = $request->input('code');
        $course->description = $request->input('description');
        $course->points = $request->input('points');
        $course->level = $request->input('level');
        $course->save();

        return $course;
    }

    public function destroy(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        if ($course->enrolments->count() == 0) {
            $course->delete();
            return response()->json(['message' => 'Successfully deleted'], 200);
        }
        else {
            return response()->json(['message' => 'Course not deleted'], 422);
        }
    }
}
