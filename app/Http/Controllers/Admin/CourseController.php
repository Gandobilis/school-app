<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseRequest;
use App\Http\Requests\Course\StudentRequest;
use App\Models\Course;
use App\Models\Student;
use App\Services\FileUploadService;
use Illuminate\Http\Response;

class CourseController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $courses = Course::all();

        return response(['courses' => $courses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request): Response
    {
        $data = $request->validated();
        $data['image'] = FileUploadService::uploadFile($data['image'], 'course/images');
        $data['syllabus'] = FileUploadService::uploadFile($data['syllabus'], 'course/syllabuses');

        $course = Course::create($data);

        if (isset($data['lecturer_ids'])) $course->lecturers()->attach($data['lecturer_ids']);

        return response(['course' => $course], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): Response
    {
        $course->load('lecturers');

        return response(['course' => $course]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course): Response
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = FileUploadService::uploadFile($data['image'], 'course/images');
            FileUploadService::deleteFile($course->getAttributes()['image']);
        }
        if (isset($data['syllabus'])) {
            $data['syllabus'] = FileUploadService::uploadFile($data['syllabus'], 'course/syllabuses');
            FileUploadService::deleteFile($course->getAttributes()['syllabus']);
        }

        $course->update($data);

        if (isset($data['lecturer_ids'])) $course->lecturers()->sync($data['lecturer_ids']);

        return response(['course' => $course->refresh()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): Response
    {
        FileUploadService::deleteFile($course->getAttributes()['image']);
        FileUploadService::deleteFile($course->getAttributes()['syllabus']);

        $course->lecturers()->detach();
        $course->delete();

        return response(["message" => "Course deleted"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(StudentRequest $request, Course $course): Response
    {
        $data = $request->validated();
        $data['course_id'] = $course->id;

        $course->students()->create($data);

        return response(['message' => "You registered successfully"], 201);
    }

    /**
     * Display a listing of the resource.
     */
    public function students(Course $course): Response
    {
        $students = $course->students()->get();

        return response(['students' => $students]);
    }
}
