<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lecturer\LecturerRequest;
use App\Models\Lecturer;
use App\Services\FileUploadService;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lecturers = Lecturer::all();

        return response(['lecturers' => $lecturers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LecturerRequest $request)
    {
        $data = $request->validated();
        $data['image'] = FileUploadService::uploadFile($data['image'], 'lecturers');

        $lecturer = Lecturer::create($data);
        if (isset($data['course_ids'])) $lecturer->courses()->attach($data['course_ids']);

        return response(['lecturer' => $lecturer], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecturer $lecturer)
    {
        $lecturer->load('courses');

        return response(['lecturer' => $lecturer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LecturerRequest $request, Lecturer $lecturer)
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = FileUploadService::uploadFile($data['image'], 'lecturers');
            FileUploadService::deleteFile($lecturer->getAttributes()['image']);
        }

        $lecturer->update($data);
        if (isset($data['course_ids'])) $lecturer->courses()->sync($data['course_ids']);

        return response(['lecturer' => $lecturer]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecturer $lecturer)
    {
        FileUploadService::deleteFile($lecturer->getAttributes()['image']);

        $lecturer->courses()->detach();
        $lecturer->delete();

        return response(["message" => "Lecturer Deleted"]);
    }
}
