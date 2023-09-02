<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lecturer\LecturerRequest;
use App\Http\Requests\Lecturer\LecturerUpdateRequest;
use App\Models\Lecturer;
use App\Services\FileUploadService;

class LecturerController extends Controller
{
    public function __construct(private FileUploadService $fileUploadService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lecturers = Lecturer::with('translation')->paginate(10);
        return response([
            'lecturers' => $lecturers
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LecturerRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->fileUploadService->fileUpload($data['image'], 'lecturer')['path'];

        $lecturer = Lecturer::create($data);

        return response([
            'lecturer' => $lecturer
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecturer $lecturer)
    {
        $lecturer->load('translation');
        return response([
            'lecturer' => $lecturer
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LecturerUpdateRequest $request, Lecturer $lecturer)
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = $this->fileUploadService->fileUpload($data['image'], 'lecturer')['path'];
            $this->fileUploadService->deleteFile($lecturer->image);
        }
        $lecturer->update($data);
        return response([
            'lecturer' => $lecturer->refresh()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecturer $lecturer)
    {
        $lecturer->delete();
        return response([
            "message" => "Lecturer Deleted"
        ], 200);
    }
}
