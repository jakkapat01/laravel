<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'topic' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // สร้างรายการใหม่
        $course = new \App\Models\Course();
        $course->topic = $request->input('topic');
        $course->start_date = $request->input('start_date');
        $course->end_date = $request->input('end_date');
        $course->save();
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::find($id);
        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::find($id);
        return view('Courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::find($id);
        $course->topic = $request->input('topic');
        $course->start_date = $request->input('start_date');
        $course->end_date = $request->input('end_date');
        $course->save();
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::find($id);
        $course->delete();

        return redirect('/courses')->with('success', 'ลบข้อมูลเรียบร้อยแล้ว !');
    }
}
