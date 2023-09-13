<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\BannerRequset;
use App\Models\banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response(['banners' => Banner::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequset $request)
    {
        $banner = Banner::create($request->validated());
        return response(['banner' => $banner]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return response(['banner' => $banner]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequset $request, Banner $banner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        //
    }
}
