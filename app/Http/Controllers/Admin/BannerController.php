<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\BannerRequest;
use App\Models\Banner;
use Illuminate\Http\Response;
use App\Services\FileUploadService;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $banners = Banner::all();

        return response(['banners' => $banners]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request): Response
    {
        $data = $request->validated();
        $data['image'] = fileUploadService::uploadFile($data['image'], 'banners');

        $banner = Banner::create($data);

        return response(['banner' => $banner], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner): Response
    {
        return response(['banner' => $banner]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, Banner $banner): Response
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $data['image'] = fileUploadService::uploadFile($data['image'], 'banners');
            FileUploadService::deleteFile($banner->getAttributes()['image']);
        }

        $banner->update($data);

        return response(['banner' => $banner]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(Banner $banner): Response
    {
        FileUploadService::deleteFile($banner->getAttributes()['image']);

        $banner->delete();

        return response(['message' => 'Banner deleted successfully']);
    }
}
