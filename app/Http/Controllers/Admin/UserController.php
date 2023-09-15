<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response(['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['image'] = FileUploadService::uploadFile($data['image'], 'users');

        $user = User::create($data);
        return response(['user' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        if (isset($data['image'])) {
            $data['image'] = FileUploadService::uploadFile($data['image'], 'users');
            FileUploadService::deleteFile($user->getAttributes()['image']);
        }

        $user->update($data);

        return response(['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        FileUploadService::deleteFile($user->getAttributes()['image']);
        $user->delete();

        return response(["message" => "User Deleted"]);
    }
}
