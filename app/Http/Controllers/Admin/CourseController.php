<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\CourseRequest;
use App\Models\Course;
use App\Models\Student;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct(private FileUploadService $fileUploadService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('translation', 'lecturers')
            ->select(['image', 'title', 'fee', 'old_fee', 'short_description'])
            ->paginate(10);

        return response(['courses' => $courses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->fileUploadService->fileUpload($data['image'], 'course/images')['path'];
        $data['syllabus'] = $this->fileUploadService->fileUpload($data['syllabus'], 'course/syllabuses')['path'];

        $course = Course::create($data);

        if (isset($data['lecturer_ids'])) $course->lecturers()->attach($data['lecturer_ids']);

        return response(['course' => $course], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->setHidden(['short_description']);

        $course->load('translation', 'lecturers');

        return response(['course' => $course]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course)
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = $this->fileUploadService->fileUpload($data['image'], 'course')['path'];
            $this->fileUploadService->deleteFile($course->image);
        }
        if (isset($data['syllabus'])) {
            $data['syllabus'] = $this->fileUploadService->fileUpload($data['syllabus'], 'course')['path'];
            $this->fileUploadService->deleteFile($course->syllabus);
        }
        $course->update($data);

        if (isset($data['lecturer_ids'])) $course->lecturers()->sync($data['lecturer_ids']);

        return response(['course' => $course->refresh()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->lecturers()->detach();
        $course->delete();

        return response(["message" => "Course Deleted"]);
    }

    public function register(Request $request)
    {
        return response(Student::create($request->all()));
    }
}
