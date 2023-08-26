<?php

namespace App\Http\Controllers;

use App\Models\Lecturer;
use App\Http\Requests\StoreLecturerRequest;
use App\Http\Requests\UpdateLecturerRequest;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lecturers = Lecturer::all();
        return response([
            'lecturers' => $lecturers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLecturerRequest $request)
    {
        $request->validated();
        $lecturer = Lecturer::create($request->all());
        return response([
            'lecturer' => $lecturer
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecturer $lecturer)
    {
        return response()->json($lecturer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLecturerRequest $request, Lecturer $lecturer)
    {
        $lecturer->update($request->all());
        return response()->json($lecturer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecturer $lecturer)
    {
        $lecturer->delete();
        return response()->json(null, 204);
    }
}
