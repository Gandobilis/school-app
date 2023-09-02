<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected FileUploadService $fileUploadService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response([
            'message' => "List of users"
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['profile_image'] = $this->fileUploadService->fileUpload($data['profile_image'])['path'];

        $user = User::create($data);
        return response([
            'message' => "User Created",
            'user' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response([
            'message' => "User Detail Data"
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        return response([
            'message' => "User Updated"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return response([
            'message' => "User Deleted"
        ], 200);
    }
}
